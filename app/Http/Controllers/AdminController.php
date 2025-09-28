<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('admin');
    }

    /**
     * Display a listing of admin users only
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(15);
        
        $stats = [
            'total_admins' => User::where('role', 'admin')->count(),
            'active_admins' => User::where('role', 'admin')->where('status', 'active')->count(),
        ];

        return view('admins.index', compact('admins', 'stats'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created admin
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['role'] = 'admin'; // Force admin role
            $data['status'] = 'active'; // Admins are active by default
            
            $admin = $this->userService->createAdmin($data);

            return redirect()
                ->route('admins.index')
                ->with('success', 'Admin created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified admin
     */
    public function show(User $admin)
    {
        // Ensure we're only showing admin users
        if ($admin->role !== 'admin') {
            abort(404);
        }

        return view('admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit(User $admin)
    {
        // Ensure we're only editing admin users
        if ($admin->role !== 'admin') {
            abort(404);
        }

        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin
     */
    public function update(UpdateUserRequest $request, User $admin)
    {
        // Ensure we're only updating admin users
        if ($admin->role !== 'admin') {
            abort(404);
        }

        try {
            $data = $request->validated();
            $data['role'] = 'admin'; // Ensure role stays admin
            
            $updatedAdmin = $this->userService->updateUser($admin, $data);

            return redirect()
                ->route('admins.show', $updatedAdmin)
                ->with('success', 'Admin updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update admin: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified admin
     */
    public function destroy(User $admin)
    {
        // Ensure we're only deleting admin users
        if ($admin->role !== 'admin') {
            abort(404);
        }

        // Prevent deleting the current admin
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        try {
            $admin->delete();

            return redirect()
                ->route('admins.index')
                ->with('success', 'Admin deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete admin: ' . $e->getMessage());
        }
    }
}