<?php

namespace App\Http\Controllers;

use App\Services\TenantService;
use App\Services\FlatService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    private TenantService $tenantService;
    private FlatService $flatService;

    public function __construct(TenantService $tenantService, FlatService $flatService)
    {
        $this->tenantService = $tenantService;
        $this->flatService = $flatService;
        $this->middleware(['auth', 'multitenant']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of tenants
     */
    public function index(): View
    {
        $tenants = $this->tenantService->getTenantsWithFlat();
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new tenant
     */
    public function create(): View
    {
        $availableFlats = $this->flatService->getAvailableFlats();
        return view('tenants.create', compact('availableFlats'));
    }

    /**
     * Store a newly created tenant
     */
    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'required|string|max:20',
            'permanent_address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'identification_type' => 'required|string|in:NID,Passport,Driving License',
            'identification_number' => 'required|string|max:100',
            'id_document_image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Required ID document image
            'security_deposit_paid' => 'required|numeric|min:0|max:999999.99',
            'flat_id' => 'required|exists:flats,id',
            'lease_start_date' => 'required|date|after_or_equal:today',
            'lease_end_date' => 'required|date|after:lease_start_date',
            'monthly_rent' => 'required|numeric|min:0|max:999999.99', // Required: monthly rent amount
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ];

        $customMessages = [
            'name.required' => 'Tenant name is required.',
            'name.max' => 'Tenant name cannot exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered to another tenant.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'permanent_address.required' => 'Permanent address is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'identification_type.required' => 'ID Type is required.',
            'identification_type.in' => 'Please select a valid identification type (NID, Passport, or Driving License).',
            'identification_number.required' => 'ID Number is required.',
            'id_document_image.required' => 'ID Document image is required.',
            'id_document_image.image' => 'ID document must be an image.',
            'id_document_image.mimes' => 'ID document must be a JPEG, PNG, or JPG image.',
            'id_document_image.max' => 'ID document image cannot exceed 5MB.',
            'security_deposit_paid.required' => 'Security deposit amount is required.',
            'security_deposit_paid.numeric' => 'Security deposit must be a valid number.',
            'security_deposit_paid.min' => 'Security deposit cannot be negative.',
            'flat_id.required' => 'Please select a flat to assign to the tenant.',
            'flat_id.exists' => 'The selected flat is invalid.',
            'lease_start_date.required' => 'Lease start date is required.',
            'lease_start_date.after_or_equal' => 'Lease start date cannot be in the past.',
            'lease_end_date.required' => 'Lease end date is required.',
            'lease_end_date.after' => 'Lease end date must be after the start date.',
            'monthly_rent.required' => 'Monthly rent amount is required.',
            'monthly_rent.numeric' => 'Monthly rent must be a valid number.',
            'monthly_rent.min' => 'Monthly rent cannot be negative.',
        ];

        $request->validate($validationRules, $customMessages);

        try {
            // Check if flat is still available
            if (!$this->flatService->isFlatAvailable($request->flat_id)) {
                return back()
                    ->withInput()
                    ->withErrors(['flat_id' => 'Selected flat is no longer available.']);
            }

            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('id_document_image')) {
                $path = $request->file('id_document_image')->store('tenant_documents', 'public');
                $data['id_document_image'] = $path;
            }

            $this->tenantService->createTenant($data);

            return redirect()->route('tenants.index')
                            ->with('success', 'Tenant added successfully! The flat has been marked as occupied.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while adding the tenant. Please try again.');
        }
    }

    /**
     * Display the specified tenant
     */
    public function show(string $id): View
    {
        $tenant = $this->tenantService->findByIdWithDetails($id);

        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        return view('tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified tenant
     */
    public function edit(string $id): View
    {
        $tenant = $this->tenantService->findById($id);
        $availableFlats = $this->flatService->getAvailableFlatsIncluding($tenant->flat_id);

        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        return view('tenants.edit', compact('tenant', 'availableFlats'));
    }

    /**
     * Update the specified tenant
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $id,
            'phone' => 'required|string|max:20',
            'permanent_address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'identification_type' => 'required|string|in:NID,Passport,Driving License',
            'identification_number' => 'required|string|max:100',
            'id_document_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Optional on update (keep existing if not provided)
            'security_deposit_paid' => 'required|numeric|min:0|max:999999.99',
            'flat_id' => 'required|exists:flats,id',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'required|date|after:lease_start_date',
            'monthly_rent' => 'required|numeric|min:0|max:999999.99', // Required: monthly rent amount
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ];

        $customMessages = [
            'name.required' => 'Tenant name is required.',
            'name.max' => 'Tenant name cannot exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered to another tenant.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'permanent_address.required' => 'Permanent address is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'identification_type.required' => 'ID Type is required.',
            'identification_type.in' => 'Please select a valid identification type (NID, Passport, or Driving License).',
            'identification_number.required' => 'ID Number is required.',
            'id_document_image.image' => 'ID document must be an image.',
            'id_document_image.mimes' => 'ID document must be a JPEG, PNG, or JPG image.',
            'id_document_image.max' => 'ID document image cannot exceed 5MB.',
            'security_deposit_paid.required' => 'Security deposit amount is required.',
            'security_deposit_paid.numeric' => 'Security deposit must be a valid number.',
            'security_deposit_paid.min' => 'Security deposit cannot be negative.',
            'flat_id.required' => 'Please select a flat to assign to the tenant.',
            'flat_id.exists' => 'The selected flat is invalid.',
            'lease_start_date.required' => 'Lease start date is required.',
            'lease_end_date.required' => 'Lease end date is required.',
            'lease_end_date.after' => 'Lease end date must be after the start date.',
            'monthly_rent.required' => 'Monthly rent amount is required.',
            'monthly_rent.numeric' => 'Monthly rent must be a valid number.',
            'monthly_rent.min' => 'Monthly rent cannot be negative.',
            'is_active.required' => 'Please specify if the tenant is active.',
        ];

        $request->validate($validationRules, $customMessages);

        try {
            $tenant = $this->tenantService->findById($id);
            if (!$tenant) {
                return back()->with('error', 'Tenant not found.');
            }

            // Check if flat is available (excluding current tenant's flat)
            if ($request->flat_id != $tenant->flat_id && !$this->flatService->isFlatAvailable($request->flat_id)) {
                return back()
                    ->withInput()
                    ->withErrors(['flat_id' => 'Selected flat is not available.']);
            }

            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('id_document_image')) {
                // Delete old file if exists
                if ($tenant->id_document_image) {
                    Storage::disk('public')->delete($tenant->id_document_image);
                }

                $path = $request->file('id_document_image')->store('tenant_documents', 'public');
                $data['id_document_image'] = $path;
            }

            $updated = $this->tenantService->update($id, $data);

            if (!$updated) {
                return back()->with('error', 'Tenant could not be updated.');
            }

            return redirect()->route('tenants.index')
                            ->with('success', 'Tenant updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the tenant. Please try again.');
        }
    }

    /**
     * Remove the specified tenant
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $deleted = $this->tenantService->delete($id);

            if (!$deleted) {
                return back()->with('error', 'Tenant not found or could not be deleted.');
            }

            return redirect()->route('tenants.index')
                            ->with('success', 'Tenant removed successfully! The flat is now available for new tenants.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while removing the tenant. Please try again.');
        }
    }
}
