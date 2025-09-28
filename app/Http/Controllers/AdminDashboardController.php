<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Models\Building;
use App\Models\Tenant;
use App\Models\Bill;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('admin');
    }

    public function index()
    {
        // System-wide statistics for admin
        $stats = [
            'total_house_owners' => $this->userService->getTotalHouseOwners(),
            'active_house_owners' => $this->userService->getActiveHouseOwners(),
            'pending_house_owners' => $this->userService->getPendingUsers()->count(),
            'total_buildings' => Building::count(),
            'total_tenants' => Tenant::count(),
            'total_bills' => Bill::count(),
            'monthly_revenue' => Bill::where('status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'pending_bills' => Bill::where('status', 'pending')->count(),
        ];

        // Recent activities across all house owners
        $recentActivities = $this->getSystemwideActivities();

        // Pending approvals
        $pendingUsers = $this->userService->getPendingUsers();

        return view('admin.dashboard', compact('stats', 'recentActivities', 'pendingUsers'));
    }

    private function getSystemwideActivities()
    {
        return collect([
            // Recent user registrations
            ...$this->userService->getRecentRegistrations(5)->map(function ($user) {
                return [
                    'type' => 'user_registration',
                    'message' => "New house owner {$user->name} registered",
                    'timestamp' => $user->created_at,
                    'user' => $user,
                ];
            }),
            
            // Recent bills created
            ...Bill::with(['tenant', 'category'])
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($bill) {
                    return [
                        'type' => 'bill_created',
                        'message' => "Bill created for {$bill->tenant->name} - {$bill->category->name}",
                        'timestamp' => $bill->created_at,
                        'bill' => $bill,
                    ];
                }),
            
            // Recent tenant additions
            ...Tenant::with(['building'])
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($tenant) {
                    return [
                        'type' => 'tenant_added',
                        'message' => "New tenant {$tenant->name} added to {$tenant->building->name}",
                        'timestamp' => $tenant->created_at,
                        'tenant' => $tenant,
                    ];
                }),
        ])->sortByDesc('timestamp')->take(10);
    }
}