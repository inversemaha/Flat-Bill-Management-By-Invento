<?php

namespace App\Http\Controllers;

use App\Services\BillService;
use App\Services\TenantService;
use App\Services\BillCategoryService;
use App\Services\FlatService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BillController extends Controller
{
    private BillService $billService;
    private TenantService $tenantService;
    private BillCategoryService $billCategoryService;
    private FlatService $flatService;

    public function __construct(
        BillService $billService,
        TenantService $tenantService,
        BillCategoryService $billCategoryService,
        FlatService $flatService
    ) {
        $this->billService = $billService;
        $this->tenantService = $tenantService;
        $this->billCategoryService = $billCategoryService;
        $this->flatService = $flatService;
        $this->middleware(['auth', 'multitenant']);
    }

    /**
     * Display a listing of bills
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'tenant_id', 'category_id', 'month', 'year']);
        $bills = $this->billService->getBillsWithFilters($filters);
        $tenants = $this->tenantService->getAllActiveTenants();
        $categories = $this->billCategoryService->getAllActiveBillCategories();

        // Check if there are any flats with tenants for bill generation
        $flatsWithTenants = $this->flatService->getOccupiedFlats();
        $hasFlatsWithTenants = !$flatsWithTenants->isEmpty();

        return view('bills.index', compact('bills', 'tenants', 'categories', 'filters', 'hasFlatsWithTenants'));
    }

    /**
     * Show the form for creating a new bill
     */
    public function create(): View
    {
        $tenants = $this->tenantService->getAllActiveTenants();
        $categories = $this->billCategoryService->getAllActiveBillCategories();

        // Check if there are any tenants available
        $hasActiveTenants = !$tenants->isEmpty();

        return view('bills.create', compact('tenants', 'categories', 'hasActiveTenants'));
    }

    /**
     * Store a newly created bill
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'bill_category_id' => 'required|exists:bill_categories,id',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'due_date' => 'required|date|after_or_equal:today',
            'bill_period_start' => 'required|date',
            'bill_period_end' => 'required|date|after_or_equal:bill_period_start',
            'description' => 'nullable|string',
            'late_fee' => 'nullable|numeric|min:0|max:99999.99',
        ]);

        $bill = $this->billService->createBill($request->all());

        // Send email notification
        $this->billService->sendBillCreatedNotification($bill);

        return redirect()->route('bills.index')
                        ->with('success', 'Bill created successfully and notification sent!');
    }

    /**
     * Display the specified bill
     */
    public function show(string $id): View
    {
        $bill = $this->billService->findByIdWithDetails($id);

        if (!$bill) {
            abort(404, 'Bill not found');
        }

        return view('bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified bill
     */
    public function edit(string $id): View
    {
        $bill = $this->billService->findById($id);
        $tenants = $this->tenantService->getAllActiveTenants();
        $categories = $this->billCategoryService->getAllActiveBillCategories();

        if (!$bill) {
            abort(404, 'Bill not found');
        }

        return view('bills.edit', compact('bill', 'tenants', 'categories'));
    }

    /**
     * Update the specified bill
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'bill_category_id' => 'required|exists:bill_categories,id',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'due_date' => 'required|date',
            'bill_period_start' => 'required|date',
            'bill_period_end' => 'required|date|after_or_equal:bill_period_start',
            'description' => 'nullable|string',
            'late_fee' => 'nullable|numeric|min:0|max:99999.99',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        $updated = $this->billService->update($id, $request->all());

        if (!$updated) {
            return back()->with('error', 'Bill not found or could not be updated.');
        }

        return redirect()->route('bills.index')
                        ->with('success', 'Bill updated successfully!');
    }

    /**
     * Mark bill as paid
     */
    public function markAsPaid(Request $request, string $id): RedirectResponse
    {
        try {
            $paymentDetails = [];
            
            // Get payment details from request if provided
            if ($request->has('payment_details')) {
                $paymentDetails['payment_details'] = $request->input('payment_details');
            }
            
            $bill = $this->billService->markAsPaid($id, $paymentDetails);

            return back()->with('success', 'Bill marked as paid and notifications sent successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified bill
     */
    public function destroy(string $id): RedirectResponse
    {
        $bill = $this->billService->findById($id);

        if (!$bill) {
            return back()->with('error', 'Bill not found.');
        }

        if ($bill->status === 'paid') {
            return back()->with('error', 'Cannot delete a paid bill.');
        }

        $deleted = $this->billService->delete($id);

        if (!$deleted) {
            return back()->with('error', 'Bill could not be deleted.');
        }

        return redirect()->route('bills.index')
                        ->with('success', 'Bill deleted successfully!');
    }

    /**
     * Generate monthly bills for all active tenants
     */
    public function generateMonthlyBills(Request $request): RedirectResponse
    {
        // First check if there are any flats with tenants
        $flatsWithTenants = $this->flatService->getOccupiedFlats();

        if ($flatsWithTenants->isEmpty()) {
            return back()->with('error', 'No flats with tenants found. Please add tenants to your flats before generating bills.');
        }

        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
            'bill_category_id' => 'required|exists:bill_categories,id',
        ]);

        // Get the building ID for the current house owner
        $building = null;
        if (auth()->user()->isHouseOwner()) {
            $building = auth()->user()->buildings()->first();
        } else if (auth()->user()->isAdmin()) {
            // For admin, we need to specify which building or generate for all buildings
            // For now, let's get the first building or handle it differently
            $building = \App\Models\Building::first();
        }

        if (!$building) {
            return back()->with('error', 'No building found. Please create a building first.');
        }

        $count = $this->billService->generateMonthlyBills(
            $building->id,
            $request->month,
            $request->year,
            $request->bill_category_id
        );

        if ($count > 0) {
            return back()->with('success', "Generated {$count} bills for {$building->name} for the selected month!");
        } else {
            return back()->with('error', 'No bills were generated. Please check if there are active tenants and no duplicate bills for this period.');
        }
    }
}
