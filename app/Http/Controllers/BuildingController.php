<?php

namespace App\Http\Controllers;

use App\Services\BuildingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BuildingController extends Controller
{
    private BuildingService $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
        $this->middleware(['auth', 'multitenant']);
    }

    /**
     * Display a listing of buildings
     */
    public function index(): View
    {
        $buildings = $this->buildingService->getBuildingsWithStats();
        return view('buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new building
     */
    public function create(): View
    {
        return view('buildings.create');
    }

    /**
     * Store a newly created building
     */
    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'total_floors' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ];

        $customMessages = [
            'name.required' => 'Building name is required.',
            'name.max' => 'Building name cannot exceed 255 characters.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'city.max' => 'City name cannot exceed 255 characters.',
            'state.required' => 'State is required.',
            'state.max' => 'State name cannot exceed 255 characters.',
            'postal_code.required' => 'Postal code is required.',
            'postal_code.max' => 'Postal code cannot exceed 20 characters.',
            'total_floors.required' => 'Total floors is required.',
            'total_floors.min' => 'Building must have at least 1 floor.',
            'total_floors.max' => 'Building cannot exceed 100 floors.',
        ];

        $request->validate($validationRules, $customMessages);

        try {
            $this->buildingService->createBuilding($request->all());

            return redirect()->route('buildings.index')
                            ->with('success', 'Building created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while creating the building. Please try again.');
        }
    }

    /**
     * Display the specified building
     */
    public function show(string $id): View
    {
        $building = $this->buildingService->findById($id);

        if (!$building) {
            abort(404, 'Building not found');
        }

        return view('buildings.show', compact('building'));
    }

    /**
     * Show the form for editing the specified building
     */
    public function edit(string $id): View
    {
        $building = $this->buildingService->findById($id);

        if (!$building) {
            abort(404, 'Building not found');
        }

        return view('buildings.edit', compact('building'));
    }

    /**
     * Update the specified building
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'total_floors' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ];

        $customMessages = [
            'name.required' => 'Building name is required.',
            'name.max' => 'Building name cannot exceed 255 characters.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'city.max' => 'City name cannot exceed 255 characters.',
            'state.required' => 'State is required.',
            'state.max' => 'State name cannot exceed 255 characters.',
            'postal_code.required' => 'Postal code is required.',
            'postal_code.max' => 'Postal code cannot exceed 20 characters.',
            'total_floors.required' => 'Total floors is required.',
            'total_floors.min' => 'Building must have at least 1 floor.',
            'total_floors.max' => 'Building cannot exceed 100 floors.',
        ];

        $request->validate($validationRules, $customMessages);

        try {
            $updated = $this->buildingService->update($id, $request->all());

            if (!$updated) {
                return back()->with('error', 'Building not found or could not be updated.');
            }

            return redirect()->route('buildings.index')
                            ->with('success', 'Building updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the building. Please try again.');
        }
    }

    /**
     * Remove the specified building
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $deleted = $this->buildingService->delete($id);

            if (!$deleted) {
                return back()->with('error', 'Building not found or could not be deleted.');
            }

            return redirect()->route('buildings.index')
                            ->with('success', 'Building and all associated flats deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete building that has active tenants. Please move tenants first.');
        }
    }
}
