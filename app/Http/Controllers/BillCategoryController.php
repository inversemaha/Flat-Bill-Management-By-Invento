<?php

namespace App\Http\Controllers;

use App\Services\BillCategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BillCategoryController extends Controller
{
    private BillCategoryService $billCategoryService;

    public function __construct(BillCategoryService $billCategoryService)
    {
        $this->billCategoryService = $billCategoryService;
        $this->middleware(['auth', 'multitenant']);
    }

    /**
     * Display a listing of bill categories
     */
    public function index(): View
    {
        $billCategories = $this->billCategoryService->getAllBillCategories();
        return view('bill-categories.index', compact('billCategories'));
    }

    /**
     * Show the form for creating a new bill category
     */
    public function create(): View
    {
        return view('bill-categories.create');
    }

    /**
     * Store a newly created bill category
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        // Check if category name already exists
        if ($this->billCategoryService->categoryNameExists($request->name)) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Bill category with this name already exists']);
        }

        $this->billCategoryService->createBillCategory($request->all());

        return redirect()->route('bill-categories.index')
                        ->with('success', 'Bill category created successfully!');
    }

    /**
     * Display the specified bill category
     */
    public function show(string $id): View
    {
        $billCategory = $this->billCategoryService->findByIdWithBills($id);

        if (!$billCategory) {
            abort(404, 'Bill category not found');
        }

        return view('bill-categories.show', compact('billCategory'));
    }

    /**
     * Show the form for editing the specified bill category
     */
    public function edit(string $id): View
    {
        $billCategory = $this->billCategoryService->findById($id);

        if (!$billCategory) {
            abort(404, 'Bill category not found');
        }

        return view('bill-categories.edit', compact('billCategory'));
    }

    /**
     * Update the specified bill category
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        // Check if category name already exists (excluding current category)
        if ($this->billCategoryService->categoryNameExistsExcept($request->name, $id)) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Bill category with this name already exists']);
        }

        $updated = $this->billCategoryService->update($id, $request->all());

        if (!$updated) {
            return back()->with('error', 'Bill category not found or could not be updated.');
        }

        return redirect()->route('bill-categories.index')
                        ->with('success', 'Bill category updated successfully!');
    }

    /**
     * Remove the specified bill category
     */
    public function destroy(string $id): RedirectResponse
    {
        // Check if category has associated bills
        $billCategory = $this->billCategoryService->findByIdWithBills($id);

        if (!$billCategory) {
            return back()->with('error', 'Bill category not found.');
        }

        if ($billCategory->bills->count() > 0) {
            return back()->with('error', 'Cannot delete bill category that has associated bills.');
        }

        $deleted = $this->billCategoryService->delete($id);

        if (!$deleted) {
            return back()->with('error', 'Bill category could not be deleted.');
        }

        return redirect()->route('bill-categories.index')
                        ->with('success', 'Bill category deleted successfully!');
    }
}
