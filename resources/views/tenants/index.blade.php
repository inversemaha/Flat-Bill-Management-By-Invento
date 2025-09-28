@extends('layouts.app')

@section('title', 'Tenants Management')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Tenants Management
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Tenants</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
    <div class="max-w-full overflow-x-auto">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                {{ auth()->user()->isAdmin() ? 'All Tenants' : 'My Tenants' }}
            </h4>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('tenants.create') }}"
                   class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Tenant
                </a>
            @endif
        </div>

        @if ($tenants->isEmpty())
            <!-- Empty State -->
            <div class="rounded-sm border border-stroke bg-white py-20 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="text-center">
                    <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center dark:bg-gray-800">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2m5-16a3 3 0 110 6m-5 6.5a3 3 0 110-6"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-black dark:text-white">No tenants found</h3>
                    <p class="mb-6 text-gray-500 dark:text-gray-400">{{ auth()->user()->isAdmin() ? 'Start by adding tenants to manage their information and assign them to flats.' : 'You have no tenants assigned yet.' }}</p>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('tenants.create') }}"
                           class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                            Add First Tenant
                        </a>
                    @endif
                </div>
            </div>
        @else
            <!-- Table -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Tenant Details</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Contact Info</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Property</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Lease Period</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Status</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Actions</p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($tenants as $tenant)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block font-medium text-black text-sm dark:text-white/90">{{ $tenant->name }}</span>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    @if($tenant->identification_type && $tenant->identification_number)
                                                        {{ $tenant->identification_type }}: {{ $tenant->identification_number }}
                                                    @else
                                                        Tenant ID: #{{ $tenant->id }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <p class="text-gray-800 text-sm dark:text-gray-200">{{ $tenant->email }}</p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">{{ $tenant->phone ?? 'No phone' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <p class="text-gray-800 text-sm font-medium dark:text-gray-200">
                                                @if($tenant->flat)
                                                    Flat {{ $tenant->flat->flat_number }}
                                                @else
                                                    <span class="text-gray-500">Not Assigned</span>
                                                @endif
                                            </p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">
                                                @if($tenant->flat && $tenant->flat->building)
                                                    {{ $tenant->flat->building->name }}
                                                @else
                                                    No Building
                                                @endif
                                            </p>
                                            @if($tenant->monthly_rent)
                                                <p class="text-gray-500 text-xs dark:text-gray-400">৳{{ number_format($tenant->monthly_rent, 2) }}/month</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($tenant->lease_start_date && $tenant->lease_end_date)
                                            <div>
                                                <p class="text-gray-800 text-sm dark:text-gray-200">{{ \Carbon\Carbon::parse($tenant->lease_start_date)->format('M d, Y') }}</p>
                                                <p class="text-gray-500 text-xs dark:text-gray-400">to {{ \Carbon\Carbon::parse($tenant->lease_end_date)->format('M d, Y') }}</p>
                                                @php
                                                    $endDate = \Carbon\Carbon::parse($tenant->lease_end_date);
                                                    $daysLeft = $endDate->diffInDays(now());
                                                @endphp
                                                @if($endDate->isPast())
                                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                                                        Expired
                                                    </span>
                                                @elseif($daysLeft <= 30)
                                                    <span class="inline-flex items-center rounded-full bg-warning-50 px-2 py-0.5 text-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                                        {{ $daysLeft }} days left
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-500 text-sm">No lease dates</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($tenant->is_active)
                                            <span class="rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                Active
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('tenants.show', $tenant->id) }}"
                                               class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                               title="View Details">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('tenants.edit', $tenant->id) }}"
                                                   class="inline-flex items-center justify-center rounded-md bg-primary py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-opacity-90"
                                                   title="Edit Tenant">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('tenants.destroy', $tenant->id) }}"
                                                      method="POST"
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this tenant? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-md bg-red-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-red-600"
                                                            title="Delete Tenant">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
