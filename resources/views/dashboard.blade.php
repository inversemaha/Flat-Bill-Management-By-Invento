@extends('layouts.app')

@section('title', 'Property Management Dashboard')

@section('content')
<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Welcome back! Here's what's happening with your properties today.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 dark:text-gray-400">Last updated:</span>
            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ now()->format('M d, Y H:i') }}</span>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Buildings Card -->
    <a href="{{ route('buildings.index') }}" class="block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Buildings</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_buildings'] ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <svg class="w-4 h-4 text-orange-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="text-xs text-orange-600 font-medium">View All Buildings</span>
                </div>
            </div>
            <div class="flex items-center justify-center w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
    </a>

    <!-- Total Flats Card -->
    <a href="{{ route('flats.index') }}" class="block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Flats</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_flats'] ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="text-xs text-blue-600 font-medium">View All Flats</span>
                </div>
            </div>
            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"/>
                </svg>
            </div>
        </div>
    </a>

    <!-- Occupied Flats Card -->
    <a href="{{ route('flats.index', ['filter' => 'occupied']) }}" class="block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Occupied Flats</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['occupied_flats'] ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">{{ $stats['total_flats'] > 0 ? round(($stats['occupied_flats'] ?? 0) / $stats['total_flats'] * 100) : 0 }}% Occupied</span>
                </div>
            </div>
            <div class="flex items-center justify-center w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </a>

    <!-- Vacant Flats Card -->
    <a href="{{ route('flats.index', ['filter' => 'vacant']) }}" class="block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vacant Flats</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['vacant_flats'] ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                    <span class="text-xs text-gray-600 font-medium">{{ $stats['total_flats'] > 0 ? round(($stats['vacant_flats'] ?? 0) / $stats['total_flats'] * 100) : 0 }}% Available</span>
                </div>
            </div>
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 dark:bg-gray-900/20 rounded-lg">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z"/>
                </svg>
            </div>
        </div>
    </a>
</div>

<!-- Financial Overview Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    <!-- Rent Collection Overview -->
    <div class="lg:col-span-2 xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rent Collection Overview</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Monthly collection trends</p>
            </div>
            <div class="flex items-center gap-2">
                <select class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option>Last 6 months</option>
                    <option>Last 12 months</option>
                    <option>This year</option>
                </select>
            </div>
        </div>
        <div id="rentCollectionChart" class="h-80"></div>
    </div>

    <!-- Pending vs Paid Bills -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bills Status</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Current month overview</p>
            </div>
        </div>
        <div id="billsStatusChart" class="h-64 mb-4"></div>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <div class="flex items-center justify-center gap-2 mb-1">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Paid</span>
                </div>
                <p class="text-2xl font-bold text-green-600">৳{{ number_format($stats['paid_amount'] ?? 0, 0) }}</p>
            </div>
            <div class="text-center">
                <div class="flex items-center justify-center gap-2 mb-1">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Pending</span>
                </div>
                <p class="text-2xl font-bold text-red-600">৳{{ number_format($stats['pending_amount'] ?? 0, 0) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Property Distribution & Financial Stats -->
<div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-8">
    <!-- Total Collected vs Outstanding -->
    <div class="xl:col-span-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Financial Performance</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Monthly collected vs outstanding amounts</p>
            </div>
            <div class="flex items-center gap-2">
                <select class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option>Last 6 months</option>
                    <option>Last 12 months</option>
                </select>
            </div>
        </div>
        <div id="financialChart" class="h-80"></div>
    </div>

    <!-- Property Distribution -->
    <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Property Status</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Occupancy distribution</p>
            </div>
        </div>
        <div id="propertyChart" class="h-48 mb-6"></div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Occupied</span>
                </div>
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['occupied_flats'] ?? 0 }} units</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Vacant</span>
                </div>
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['vacant_flats'] ?? 0 }} units</span>
            </div>
            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Occupancy Rate</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $stats['total_flats'] > 0 ? round(($stats['occupied_flats'] ?? 0) / $stats['total_flats'] * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activities</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Latest system activities showing user roles, login times, and status</p>
            </div>
            <button class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                View All
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Login Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Logout Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentActivities ?? [] as $activity)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <!-- User Info -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr($activity['user_name'] ?? 'U', 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity['user_name'] ?? 'Unknown User' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['user_email'] ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Role -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $roleConfig = [
                                'admin' => ['bg' => 'bg-purple-100 dark:bg-purple-900/20', 'text' => 'text-purple-800 dark:text-purple-400', 'label' => 'Admin'],
                                'house_owner' => ['bg' => 'bg-blue-100 dark:bg-blue-900/20', 'text' => 'text-blue-800 dark:text-blue-400', 'label' => 'House Owner'],
                                'tenant' => ['bg' => 'bg-green-100 dark:bg-green-900/20', 'text' => 'text-green-800 dark:text-green-400', 'label' => 'Tenant'],
                                'default' => ['bg' => 'bg-gray-100 dark:bg-gray-900/20', 'text' => 'text-gray-800 dark:text-gray-400', 'label' => 'User']
                            ];
                            $config = $roleConfig[$activity['role_class'] ?? 'default'] ?? $roleConfig['default'];
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            {{ $activity['role'] ?? 'User' }}
                        </span>
                    </td>
                    
                    <!-- Login Time -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">{{ $activity['login_time'] ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['time'] ?? 'Unknown' }}</p>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Logout Time -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            @if($activity['logout_time'] === 'Active')
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </div>
                                <span class="text-green-600 dark:text-green-400 font-medium">{{ $activity['logout_time'] }}</span>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <span class="text-red-600 dark:text-red-400">{{ $activity['logout_time'] }}</span>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusConfig = [
                                'online' => ['bg' => 'bg-green-100 dark:bg-green-900/20', 'text' => 'text-green-800 dark:text-green-400', 'dot' => 'bg-green-400'],
                                'offline' => ['bg' => 'bg-gray-100 dark:bg-gray-900/20', 'text' => 'text-gray-800 dark:text-gray-400', 'dot' => 'bg-gray-400'],
                                'away' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/20', 'text' => 'text-yellow-800 dark:text-yellow-400', 'dot' => 'bg-yellow-400']
                            ];
                            $status = $activity['status'] ?? 'offline';
                            $config = $statusConfig[$status] ?? $statusConfig['offline'];
                        @endphp
                        <div class="flex items-center">
                            <div class="w-2 h-2 {{ $config['dot'] }} rounded-full mr-2"></div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No recent user activities</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart colors for consistent theming
    const colors = {
        primary: '#3b82f6',
        success: '#10b981',
        warning: '#f59e0b',
        error: '#ef4444',
        gray: '#6b7280'
    };

    // Rent Collection Chart - Line Chart
    if (document.getElementById('rentCollectionChart')) {
        const rentOptions = {
            series: [{
                name: 'Rent Collected',
                data: [45000, 52000, 48000, 61000, 55000, 67000]
            }, {
                name: 'Target Amount',
                data: [50000, 50000, 50000, 60000, 60000, 65000]
            }],
            chart: {
                type: 'line',
                height: 320,
                toolbar: { show: false },
                background: 'transparent'
            },
            colors: [colors.success, colors.primary],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 6,
                strokeWidth: 2,
                fillOpacity: 1,
                strokeOpacity: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return '৳' + (value / 1000).toFixed(0) + 'k';
                    },
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 3,
                yaxis: {
                    lines: { show: true }
                }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: {
                    formatter: function (value) {
                        return '৳' + value.toLocaleString();
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '14px',
                fontFamily: 'Outfit',
                offsetY: -5
            }
        };

        const rentChart = new ApexCharts(document.getElementById('rentCollectionChart'), rentOptions);
        rentChart.render();
    }

    // Bills Status Chart - Donut Chart
    if (document.getElementById('billsStatusChart')) {
        const paidAmount = {{ $stats['paid_amount'] ?? 75000 }};
        const pendingAmount = {{ $stats['pending_amount'] ?? 25000 }};

        const billsOptions = {
            series: [paidAmount, pendingAmount],
            chart: {
                type: 'donut',
                height: 260,
                background: 'transparent'
            },
            colors: [colors.success, colors.error],
            labels: ['Paid Bills', 'Pending Bills'],
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    const value = opts.w.config.series[opts.seriesIndex];
                    return '৳' + (value / 1000).toFixed(0) + 'k';
                },
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                },
                dropShadow: {
                    enabled: false
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '16px',
                                fontWeight: 'bold',
                                formatter: function (w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return '৳' + (total / 1000).toFixed(0) + 'k';
                                }
                            }
                        }
                    }
                }
            },
            legend: { show: false },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: {
                    formatter: function (value) {
                        return '৳' + value.toLocaleString();
                    }
                }
            }
        };

        const billsChart = new ApexCharts(document.getElementById('billsStatusChart'), billsOptions);
        billsChart.render();
    }

    // Financial Performance Chart - Bar Chart
    if (document.getElementById('financialChart')) {
        const financialOptions = {
            series: [{
                name: 'Collected',
                data: [65000, 70000, 55000, 85000, 60000, 95000]
            }, {
                name: 'Outstanding',
                data: [15000, 10000, 25000, 5000, 20000, 8000]
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                background: 'transparent'
            },
            colors: [colors.success, colors.error],
            dataLabels: { enabled: false },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded',
                    borderRadius: 4
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return '৳' + (value / 1000).toFixed(0) + 'k';
                    },
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 3,
                yaxis: {
                    lines: { show: true }
                }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: {
                    formatter: function (value) {
                        return '৳' + value.toLocaleString();
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '14px',
                fontFamily: 'Outfit',
                offsetY: -5
            }
        };

        const financialChart = new ApexCharts(document.getElementById('financialChart'), financialOptions);
        financialChart.render();
    }

    // Property Status Chart - Donut Chart
    if (document.getElementById('propertyChart')) {
        const occupiedFlats = {{ $stats['occupied_flats'] ?? 75 }};
        const vacantFlats = {{ $stats['vacant_flats'] ?? 25 }};

        const propertyOptions = {
            series: [occupiedFlats, vacantFlats],
            chart: {
                type: 'donut',
                height: 200,
                background: 'transparent'
            },
            colors: [colors.success, colors.gray],
            labels: ['Occupied', 'Vacant'],
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return Math.round(val) + '%';
                },
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Units',
                                fontSize: '14px',
                                fontWeight: 'bold',
                                formatter: function (w) {
                                    return {{ $stats['total_flats'] ?? 100 }};
                                }
                            }
                        }
                    }
                }
            },
            legend: { show: false },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: {
                    formatter: function (value, { seriesIndex }) {
                        const actualValue = seriesIndex === 0 ? occupiedFlats : vacantFlats;
                        return actualValue + ' units (' + Math.round(value) + '%)';
                    }
                }
            }
        };

        const propertyChart = new ApexCharts(document.getElementById('propertyChart'), propertyOptions);
        propertyChart.render();
    }

    // Update charts on dark mode toggle
    function updateChartsTheme() {
        const isDark = document.documentElement.classList.contains('dark');
        const tooltipTheme = isDark ? 'dark' : 'light';

        // Update all charts with new tooltip theme
        [rentChart, billsChart, financialChart, propertyChart].forEach(chart => {
            if (chart) {
                chart.updateOptions({
                    tooltip: { theme: tooltipTheme }
                });
            }
        });
    }

    // Listen for dark mode changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                updateChartsTheme();
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
});
</script>
@endpush
@endsection
