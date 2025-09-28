<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Flat;
use App\Models\Tenant;
use App\Models\Bill;
use App\Models\BillCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Basic stats
        if ($user->isAdmin()) {
            $totalBuildings = Building::count();
            $totalFlats = Flat::count();
            $occupiedFlats = Flat::where('is_occupied', true)->count();
            $vacantFlats = Flat::where('is_occupied', false)->count();
            $totalTenants = Tenant::count();
            $totalBills = Bill::count();
            $paidBills = Bill::where('status', 'paid')->count();
            $unpaidBills = Bill::where('status', 'unpaid')->count();
        } else {
            $userBuildings = Building::where('house_owner_id', $user->id)->pluck('id');
            $totalBuildings = $userBuildings->count();
            $totalFlats = Flat::whereIn('building_id', $userBuildings)->count();
            $occupiedFlats = Flat::whereIn('building_id', $userBuildings)->where('is_occupied', true)->count();
            $vacantFlats = Flat::whereIn('building_id', $userBuildings)->where('is_occupied', false)->count();
            $totalTenants = Tenant::whereHas('flat', function($q) use ($userBuildings) {
                $q->whereIn('building_id', $userBuildings);
            })->count();
            $totalBills = Bill::whereHas('flat', function($q) use ($userBuildings) {
                $q->whereIn('building_id', $userBuildings);
            })->count();
            $paidBills = Bill::whereHas('flat', function($q) use ($userBuildings) {
                $q->whereIn('building_id', $userBuildings);
            })->where('status', 'paid')->count();
            $unpaidBills = Bill::whereHas('flat', function($q) use ($userBuildings) {
                $q->whereIn('building_id', $userBuildings);
            })->where('status', 'unpaid')->count();
        }

        $stats = [
            'total_buildings' => $totalBuildings,
            'total_flats' => $totalFlats,
            'occupied_flats' => $occupiedFlats,
            'vacant_flats' => $vacantFlats,
            'total_tenants' => $totalTenants,
            'total_bills' => $totalBills,
            'paid_bills' => $paidBills,
            'unpaid_bills' => $unpaidBills,
        ];

        // Property distribution by bedroom count
        if ($user->isAdmin()) {
            $propertyDistribution = Flat::selectRaw('CONCAT(bedrooms, " BHK") as flat_type, count(*) as count')
                ->groupBy('bedrooms')
                ->pluck('count', 'flat_type')
                ->toArray();
        } else {
            $propertyDistribution = Flat::whereIn('building_id', $userBuildings)
                ->selectRaw('CONCAT(bedrooms, " BHK") as flat_type, count(*) as count')
                ->groupBy('bedrooms')
                ->pluck('count', 'flat_type')
                ->toArray();
        }

        // Rent collection data (dummy data for now)
        $rentCollectionData = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [65000, 72000, 68000, 75000, 70000, 80000]
        ];

        // Bills status distribution
        $billsStatusData = [
            'labels' => ['Paid Bills', 'Unpaid Bills'],
            'data' => [$paidBills, $unpaidBills]
        ];

        // Financial performance (dummy data)
        $financialPerformanceData = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'income' => [80000, 85000, 88000, 92000, 87000, 95000],
            'expenses' => [25000, 28000, 26000, 30000, 29000, 32000]
        ];

        // Recent activities - User login/logout activities with payment status
        $recentActivities = collect();

        // Get recent users with actual login data
        if ($user->isAdmin()) {
            $recentUsers = User::whereNotNull('last_login_at')
                ->orderBy('last_login_at', 'desc')
                ->take(15)
                ->get();
        } else {
            // For non-admin users, show limited data
            $recentUsers = User::whereNotNull('last_login_at')
                ->where(function($query) use ($user) {
                    $query->where('id', $user->id);
                    if ($user->isHouseOwner()) {
                        $query->orWhere('role', 'tenant');
                    }
                })
                ->orderBy('last_login_at', 'desc')
                ->take(8)
                ->get();
        }

        foreach ($recentUsers as $activityUser) {
            $lastLogin = $activityUser->last_login_at;
            
            if ($lastLogin) {
                // Determine online status (online if logged in within last 15 minutes)
                $isOnline = $lastLogin->diffInMinutes(now()) < 15;
                
                // Role display mapping
                $roleDisplay = [
                    'admin' => 'Administrator',
                    'house_owner' => 'House Owner',
                    'tenant' => 'Tenant',
                ];
                
                // Add login activity
                $recentActivities->push([
                    'user_name' => $activityUser->name,
                    'user_email' => $activityUser->email,
                    'role' => $roleDisplay[$activityUser->role] ?? 'User',
                    'role_class' => $activityUser->role,
                    'activity_type' => 'login',
                    'activity_description' => 'User logged in to system',
                    'time' => $lastLogin->diffForHumans(),
                    'exact_time' => $lastLogin->format('M j, Y H:i'),
                    'login_time' => $lastLogin->format('H:i'),
                    'logout_time' => $isOnline ? 'Active' : 'Session ended',
                    'status' => $isOnline ? 'online' : 'offline',
                    'created_at' => $lastLogin
                ]);
            }
        }

        // If no users have logged in yet, add current user's activity
        if ($recentActivities->isEmpty()) {
            $recentActivities->push([
                'user_name' => $user->name,
                'user_email' => $user->email,
                'role' => $user->isAdmin() ? 'Administrator' : ($user->isHouseOwner() ? 'House Owner' : 'User'),
                'role_class' => $user->role,
                'activity_type' => 'login',
                'activity_description' => 'Current session',
                'time' => 'Active now',
                'exact_time' => now()->format('M j, Y H:i'),
                'login_time' => now()->format('H:i'),
                'logout_time' => 'Active',
                'status' => 'online',
                'created_at' => now()
            ]);
        }

        // Sort activities by date and take the most recent ones
        $recentActivities = $recentActivities->sortByDesc('created_at')->take(10);

        return view('dashboard', compact(
            'stats',
            'propertyDistribution',
            'rentCollectionData',
            'billsStatusData',
            'financialPerformanceData',
            'recentActivities'
        ));
    }
}
