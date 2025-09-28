<?php

namespace App\Http\Controllers;

use App\Services\FlatService;
use App\Services\BuildingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FlatController extends Controller
{
    private FlatService $flatService;
    private BuildingService $buildingService;

    public function __construct(FlatService $flatService, BuildingService $buildingService)
    {
        $this->flatService = $flatService;
        $this->buildingService = $buildingService;
        $this->middleware(['auth', 'multitenant']);
    }

    /**
     * Display a listing of flats
     */
    public function index(): View
    {
        $flats = $this->flatService->getFlatsWithBuilding();
        return view('flats.index', compact('flats'));
    }

    /**
     * Show the form for creating a new flat
     */
    public function create(): View
    {
        $buildings = $this->buildingService->getAllBuildings();
        return view('flats.create', compact('buildings'));
    }

    /**
     * Store a newly created flat
     */
    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'building_id' => 'required|exists:buildings,id',
            'flat_number' => 'required|string|max:20',
            'floor' => 'required|integer|min:0|max:100',
            'bedrooms' => 'required|integer|min:1|max:10',
            'bathrooms' => 'required|integer|min:1|max:10',
            'rent_amount' => 'nullable|numeric|min:0|max:999999.99',
            'area_sqft' => 'nullable|numeric|min:1|max:10000',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'owner_email' => 'nullable|email|max:255',
            'owner_address' => 'nullable|string',
        ];

        $request->validate($validationRules, [
            'building_id.required' => 'Please select a building.',
            'building_id.exists' => 'The selected building is invalid.',
            'flat_number.required' => 'Flat number is required.',
            'flat_number.max' => 'Flat number cannot exceed 20 characters.',
            'floor.required' => 'Floor number is required.',
            'floor.min' => 'Floor number must be at least 0.',
            'floor.max' => 'Floor number cannot exceed 100.',
            'bedrooms.required' => 'Number of bedrooms is required.',
            'bedrooms.min' => 'Must have at least 1 bedroom.',
            'bedrooms.max' => 'Cannot exceed 10 bedrooms.',
            'bathrooms.required' => 'Number of bathrooms is required.',
            'bathrooms.min' => 'Must have at least 1 bathroom.',
            'bathrooms.max' => 'Cannot exceed 10 bathrooms.',
            'rent_amount.numeric' => 'Rent amount must be a valid number.',
            'rent_amount.min' => 'Rent amount cannot be negative.',
            'area_sqft.numeric' => 'Area must be a valid number.',
            'area_sqft.min' => 'Area must be at least 1 square feet.',
            'owner_email.email' => 'Please enter a valid email address.',
        ]);

        try {
            // Check if flat number already exists in the building
            if ($this->flatService->flatNumberExists($request->building_id, $request->flat_number)) {
                return back()
                    ->withInput()
                    ->withErrors(['flat_number' => 'Flat number already exists in this building.']);
            }

            $this->flatService->createFlat($request->all());

            return redirect()->route('flats.index')
                            ->with('success', 'Flat created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while creating the flat. Please try again.');
        }
    }

    /**
     * Display the specified flat
     */
    public function show(string $id): View
    {
        $flat = $this->flatService->findByIdWithDetails($id);

        if (!$flat) {
            abort(404, 'Flat not found');
        }

        return view('flats.show', compact('flat'));
    }

    /**
     * Show the form for editing the specified flat
     */
    public function edit(string $id): View
    {
        $flat = $this->flatService->findById($id);
        $buildings = $this->buildingService->getAllBuildings();

        if (!$flat) {
            abort(404, 'Flat not found');
        }

        return view('flats.edit', compact('flat', 'buildings'));
    }

    /**
     * Update the specified flat
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validationRules = [
            'building_id' => 'required|exists:buildings,id',
            'flat_number' => 'required|string|max:20',
            'floor' => 'required|integer|min:0|max:100',
            'bedrooms' => 'required|integer|min:1|max:10',
            'bathrooms' => 'required|integer|min:1|max:10',
            'rent_amount' => 'nullable|numeric|min:0|max:999999.99',
            'area_sqft' => 'nullable|numeric|min:1|max:10000',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'owner_email' => 'nullable|email|max:255',
            'owner_address' => 'nullable|string',
        ];

        $request->validate($validationRules, [
            'building_id.required' => 'Please select a building.',
            'building_id.exists' => 'The selected building is invalid.',
            'flat_number.required' => 'Flat number is required.',
            'flat_number.max' => 'Flat number cannot exceed 20 characters.',
            'floor.required' => 'Floor number is required.',
            'floor.min' => 'Floor number must be at least 0.',
            'floor.max' => 'Floor number cannot exceed 100.',
            'bedrooms.required' => 'Number of bedrooms is required.',
            'bedrooms.min' => 'Must have at least 1 bedroom.',
            'bedrooms.max' => 'Cannot exceed 10 bedrooms.',
            'bathrooms.required' => 'Number of bathrooms is required.',
            'bathrooms.min' => 'Must have at least 1 bathroom.',
            'bathrooms.max' => 'Cannot exceed 10 bathrooms.',
            'rent_amount.numeric' => 'Rent amount must be a valid number.',
            'rent_amount.min' => 'Rent amount cannot be negative.',
            'area_sqft.numeric' => 'Area must be a valid number.',
            'area_sqft.min' => 'Area must be at least 1 square feet.',
            'owner_email.email' => 'Please enter a valid email address.',
        ]);

        try {
            // Check if flat number already exists in the building (excluding current flat)
            if ($this->flatService->flatNumberExistsExcept($request->building_id, $request->flat_number, $id)) {
                return back()
                    ->withInput()
                    ->withErrors(['flat_number' => 'Flat number already exists in this building.']);
            }

            $updated = $this->flatService->update($id, $request->all());

            if (!$updated) {
                return back()->with('error', 'Flat not found or could not be updated.');
            }

            return redirect()->route('flats.index')
                            ->with('success', 'Flat updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the flat. Please try again.');
        }
    }

    /**
     * Remove the specified flat
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $deleted = $this->flatService->delete($id);

            if (!$deleted) {
                return back()->with('error', 'Flat not found or could not be deleted.');
            }

            return redirect()->route('flats.index')
                            ->with('success', 'Flat deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete flat that has active tenants. Please relocate tenants first.');
        }
    }
}
