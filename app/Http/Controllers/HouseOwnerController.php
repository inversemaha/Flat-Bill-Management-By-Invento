<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class HouseOwnerController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('admin');
    }

    /**
     * Display a listing of house owner users only
     */
    public function index()
    {
        $houseOwners = User::where('role', 'house_owner')
            ->with(['buildings'])
            ->paginate(15);
        
        $stats = [
            'total_house_owners' => User::where('role', 'house_owner')->count(),
            'active_house_owners' => User::where('role', 'house_owner')->where('status', 'active')->count(),
            'pending_house_owners' => User::where('role', 'house_owner')->where('status', 'pending')->count(),
            'inactive_house_owners' => User::where('role', 'house_owner')->where('status', 'inactive')->count(),
        ];

        return view('house-owners.index', compact('houseOwners', 'stats'));
    }

    /**
     * Show the form for creating a new house owner
     */
    public function create()
    {
        return view('house-owners.create');
    }

    /**
     * Store a newly created house owner
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['role'] = 'house_owner'; // Force house owner role
            $data['status'] = 'pending'; // House owners start as pending
            
            $houseOwner = $this->userService->createHouseOwner($data);

            return redirect()
                ->route('house-owners.index')
                ->with('success', 'House Owner created successfully. Status: Pending approval.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create house owner: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified house owner
     */
    public function show(User $houseOwner)
    {
        // Ensure we're only showing house owner users
        if ($houseOwner->role !== 'house_owner') {
            abort(404);
        }

        $houseOwner->load(['buildings', 'buildings.flats', 'buildings.tenants']);

        return view('house-owners.show', compact('houseOwner'));
    }

    /**
     * Show the form for editing the specified house owner
     */
    public function edit(User $houseOwner)
    {
        // Ensure we're only editing house owner users
        if ($houseOwner->role !== 'house_owner') {
            abort(404);
        }

        return view('house-owners.edit', compact('houseOwner'));
    }

    /**
     * Update the specified house owner
     */
    public function update(UpdateUserRequest $request, User $houseOwner)
    {
        // Ensure we're only updating house owner users
        if ($houseOwner->role !== 'house_owner') {
            abort(404);
        }

        try {
            $data = $request->validated();
            $data['role'] = 'house_owner'; // Ensure role stays house owner
            
            $updatedHouseOwner = $this->userService->updateUser($houseOwner, $data);

            return redirect()
                ->route('house-owners.show', $updatedHouseOwner)
                ->with('success', 'House Owner updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update house owner: ' . $e->getMessage());
        }
    }

    /**
     * Approve a pending house owner
     */
    public function approve(User $houseOwner)
    {
        try {
            if ($houseOwner->role !== 'house_owner' || $houseOwner->status !== 'pending') {
                throw new \Exception('User is not a pending house owner');
            }

            $this->userService->approveHouseOwner($houseOwner);

            return back()->with('success', 'House Owner approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve house owner: ' . $e->getMessage());
        }
    }

    /**
     * Deactivate a house owner
     */
    public function deactivate(User $houseOwner)
    {
        try {
            if ($houseOwner->role !== 'house_owner') {
                throw new \Exception('User is not a house owner');
            }

            $this->userService->deactivateUser($houseOwner);

            return back()->with('success', 'House Owner deactivated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to deactivate house owner: ' . $e->getMessage());
        }
    }

    /**
     * Reactivate a house owner
     */
    public function reactivate(User $houseOwner)
    {
        try {
            if ($houseOwner->role !== 'house_owner') {
                throw new \Exception('User is not a house owner');
            }

            $this->userService->reactivateUser($houseOwner);

            return back()->with('success', 'House Owner reactivated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reactivate house owner: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified house owner
     */
    public function destroy(User $houseOwner)
    {
        // Ensure we're only deleting house owner users
        if ($houseOwner->role !== 'house_owner') {
            abort(404);
        }

        try {
            $houseOwner->delete();

            return redirect()
                ->route('house-owners.index')
                ->with('success', 'House Owner deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete house owner: ' . $e->getMessage());
        }
    }
}