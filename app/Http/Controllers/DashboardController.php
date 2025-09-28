<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Recent activities - simplified
        $recentActivities = collect();

        // Get recent bills
        if ($user->isAdmin()) {
            $recentBills = Bill::with(['flat.building'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $recentBills = Bill::with(['flat.building'])
                ->whereHas('flat', function($q) use ($userBuildings) {
                    $q->whereIn('building_id', $userBuildings);
                })
                ->latest()
                ->take(5)
                ->get();
        }

        foreach ($recentBills as $bill) {
            // Get tenant for this flat
            $tenant = Tenant::where('flat_id', $bill->flat_id)->first();

            $recentActivities->push([
                'id' => $bill->id,
                'type' => 'bill',
                'tenant_name' => $tenant ? $tenant->name : 'No Tenant',
                'flat_number' => $bill->flat->flat_number,
                'building_name' => $bill->flat->building->name,
                'amount' => $bill->amount,
                'status' => $bill->status,
                'date' => $bill->created_at->format('M d, Y'),
                'activity' => 'Bill Generated'
            ]);
        }

        // Sort activities by date
        $recentActivities = $recentActivities->sortByDesc('date')->take(10);

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
