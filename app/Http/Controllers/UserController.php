<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Only admin can access user management
        $this->userService = $userService;
    }

    /**
     * Display a listing of house owners and admins
     */
    public function index(): View
    {
        $houseOwners = $this->userService->getPaginatedHouseOwners(15);
        $pendingHouseOwners = $this->userService->getPendingHouseOwners();
        $admins = $this->userService->getAdmins();
        $stats = $this->userService->getUserStats();

        return view('users.index', compact('houseOwners', 'pendingHouseOwners', 'admins', 'stats'));
    }

    /**
     * Show the form for creating a new user (house owner or admin)
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:house_owner,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->only(['name', 'email', 'password', 'phone', 'address']);

            if ($request->role === 'admin') {
                $user = $this->userService->createAdmin($data);
                $message = 'Admin created successfully!';
            } else {
                $user = $this->userService->createHouseOwner($data);
                $message = 'House Owner created successfully and activated!';
            }

            return redirect()->route('users.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user): View
    {
        $user->load(['buildings.flats', 'billCategories']);
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->only(['name', 'email', 'password', 'phone', 'address']);
            $this->userService->updateUser($user, $data);

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            // Prevent deletion of current admin
            if ($user->id === auth()->id()) {
                return back()->with('error', 'You cannot delete your own account!');
            }

            // Prevent deletion of admin users
            if ($user->isAdmin()) {
                return back()->with('error', 'Admin users cannot be deleted!');
            }

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Approve a pending house owner
     */
    public function approve(User $user): JsonResponse
    {
        try {
            $this->userService->approveHouseOwner($user);

            return response()->json([
                'success' => true,
                'message' => 'House Owner approved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Deactivate a user
     */
    public function deactivate(User $user): JsonResponse
    {
        try {
            $this->userService->deactivateUser($user);

            return response()->json([
                'success' => true,
                'message' => 'User deactivated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Reactivate a user
     */
    public function reactivate(User $user): JsonResponse
    {
        try {
            $this->userService->reactivateUser($user);

            return response()->json([
                'success' => true,
                'message' => 'User reactivated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}