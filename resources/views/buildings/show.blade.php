@extends('layouts.app')

@section('title', 'Building Details')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Building Details: {{ $building->name }}
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route('buildings.index') }}">Buildings /</a>
            </li>
            <li class="font-medium text-primary">Details</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<!-- Building Information -->
<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-3">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Building Information
                </h3>
            </div>
            <div class="p-7">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="border-b border-stroke pb-5 dark:border-strokedark">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Building Name
                        </label>
                        <p class="text-black dark:text-white font-semibold">
                            {{ $building->name }}
                        </p>
                    </div>

                    <div class="border-b border-stroke pb-5 dark:border-strokedark">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Total Floors
                        </label>
                        <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-sm font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                            {{ $building->total_floors }} Floors
                        </span>
                    </div>

                    <div class="border-b border-stroke pb-5 dark:border-strokedark md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Complete Address
                        </label>
                        <p class="text-black dark:text-white">
                            {{ $building->address }}<br>
                            <span class="text-gray-500">{{ $building->city }}, {{ $building->state }} {{ $building->postal_code }}</span>
                        </p>
                    </div>

                    <div class="border-b border-stroke pb-5 dark:border-strokedark">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Total Flats
                        </label>
                        <p class="text-2xl font-bold text-black dark:text-white">
                            {{ $building->flats->count() }}
                        </p>
                    </div>

                    <div class="border-b border-stroke pb-5 dark:border-strokedark">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Occupied Flats
                        </label>
                        @php
                            $occupied = $building->flats->where('is_occupied', true)->count();
                            $total = $building->flats->count();
                            $percentage = $total > 0 ? round(($occupied / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-3">
                            <p class="text-2xl font-bold text-black dark:text-white">{{ $occupied }}</p>
                            @if($percentage >= 80)
                                <span class="rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                    {{ $percentage }}%
                                </span>
                            @elseif($percentage >= 50)
                                <span class="rounded-full bg-warning-50 px-2 py-0.5 text-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                    {{ $percentage }}%
                                </span>
                            @else
                                <span class="rounded-full bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-500/15 dark:text-gray-400">
                                    {{ $percentage }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="pb-5">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Created Date
                        </label>
                        <p class="text-black dark:text-white">
                            {{ $building->created_at->format('F j, Y') }}
                        </p>
                        <p class="text-gray-500 text-sm">
                            {{ $building->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                @if($building->description)
                    <div class="mt-6 border-t border-stroke pt-6 dark:border-strokedark">
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Description
                        </label>
                        <p class="text-black dark:text-white">
                            {{ $building->description }}
                        </p>
                    </div>
                @endif

                <div class="flex gap-4 mt-8">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('buildings.edit', $building->id) }}"
                       class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Building
                    </a>
                    @endif
                    <a href="{{ route('buildings.index') }}"
                       class="inline-flex items-center justify-center rounded-md border border-stroke py-2 px-6 text-center font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        Back to Buildings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-5 xl:col-span-2">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Quick Stats
                </h3>
            </div>
            <div class="p-7">
                <!-- Occupancy Chart -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="font-medium text-black dark:text-white">Occupancy Rate</h5>
                        <span class="text-2xl font-bold text-primary">{{ $percentage }}%</span>
                    </div>
                    <div class="h-3 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="h-3 bg-primary rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mt-2">
                        <span>{{ $occupied }} occupied</span>
                        <span>{{ $total - $occupied }} available</span>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="space-y-4">
                    <h5 class="font-medium text-black dark:text-white">Recent Activity</h5>
                    @if($building->flats->sortByDesc('created_at')->take(3)->count() > 0)
                        @foreach($building->flats->sortByDesc('created_at')->take(3) as $flat)
                            <div class="flex items-center gap-3 border-b border-stroke pb-3 last:border-b-0 dark:border-strokedark">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v2zm0 0h18m-9 2v6"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-black dark:text-white">
                                        Flat {{ $flat->flat_number }} added
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $flat->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">No activity yet.</p>
                    @endif
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('flats.create', ['building_id' => $building->id]) }}"
                       class="w-full inline-flex items-center justify-center rounded-md bg-success py-2 px-4 text-center font-medium text-white hover:bg-opacity-90">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Flat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flats List -->
<div class="mt-8 rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="px-7 py-4 border-b border-stroke dark:border-strokedark">
        <div class="flex justify-between items-center">
            <h3 class="font-medium text-black dark:text-white">
                Flats in {{ $building->name }}
            </h3>
            <a href="{{ route('flats.create', ['building_id' => $building->id]) }}"
               class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 text-sm">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Flat
            </a>
        </div>
    </div>
    <div class="p-7">
        @if($building->flats->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center dark:bg-gray-800">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v2zm0 0h18m-9 2v6"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-black dark:text-white">No flats found</h3>
                <p class="mb-6 text-gray-500 dark:text-gray-400">Start by adding flats to this building to manage tenants and bills.</p>
                <a href="{{ route('flats.create', ['building_id' => $building->id]) }}"
                   class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    Add First Flat
                </a>
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
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Flat Details</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Type & Rent</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Status</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Tenant</p>
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
                            @foreach($building->flats as $flat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                                <span class="font-medium text-black dark:text-white">{{ $flat->flat_number }}</span>
                                            </div>
                                            <div>
                                                <span class="block font-medium text-black text-sm dark:text-white/90">Flat {{ $flat->flat_number }}</span>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">Floor {{ $flat->floor_number }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <p class="text-black text-sm font-medium dark:text-white/90">{{ $flat->flat_type }}</p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">${{ number_format($flat->rent_amount, 2) }}/month</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($flat->is_occupied)
                                            <span class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                                                Occupied
                                            </span>
                                        @else
                                            <span class="rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                Available
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($flat->tenant)
                                            <a href="{{ route('tenants.show', $flat->tenant->id) }}"
                                               class="text-primary hover:text-primary/80 text-sm font-medium">
                                                {{ $flat->tenant->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 text-sm">No Tenant</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <a href="{{ route('flats.show', $flat->id) }}"
                                           class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                           title="View Details">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
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
