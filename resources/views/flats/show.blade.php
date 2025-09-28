@extends('layouts.app')

@section('title', 'Flat Details - ' . $flat->flat_number)

@section('content')
<!-- Header Section -->
<div class="mb-6">
    <!-- Breadcrumb -->
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-title-md2 font-bold text-black dark:text-white mb-2">
                {{ $flat->building->name }} - Flat {{ $flat->flat_number }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ $flat->building->address }}, {{ $flat->building->city }}, {{ $flat->building->state }}
            </p>
        </div>
        <nav>
            <ol class="flex items-center gap-2">
                <li><a class="font-medium text-primary hover:underline" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="text-gray-500">/</li>
                <li><a class="font-medium text-primary hover:underline" href="{{ route('flats.index') }}">Flats</a></li>
                <li class="text-gray-500">/</li>
                <li class="font-medium text-gray-700 dark:text-gray-300">{{ $flat->flat_number }}</li>
            </ol>
        </nav>
    </div>

    <!-- Status Banner -->
    <div class="mb-6 rounded-lg border-l-4 border-{{ $flat->is_occupied ? 'red' : 'green' }}-500 bg-{{ $flat->is_occupied ? 'red' : 'green' }}-50 p-4 dark:bg-{{ $flat->is_occupied ? 'red' : 'green' }}-900/20">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @if($flat->is_occupied)
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-{{ $flat->is_occupied ? 'red' : 'green' }}-800 dark:text-{{ $flat->is_occupied ? 'red' : 'green' }}-200">
                        {{ $flat->is_occupied ? 'Currently Occupied' : 'Available for Rent' }}
                    </p>
                    <p class="text-xs text-{{ $flat->is_occupied ? 'red' : 'green' }}-600 dark:text-{{ $flat->is_occupied ? 'red' : 'green' }}-400">
                        @if($flat->is_occupied && $flat->tenants->count() > 0)
                            Occupied by {{ $flat->tenants->count() }} tenant{{ $flat->tenants->count() > 1 ? 's' : '' }}
                        @else
                            Ready for immediate occupancy
                        @endif
                    </p>
                </div>
            </div>
            @if($flat->rent_amount)
                <div class="text-right">
                    <p class="text-2xl font-bold text-{{ $flat->is_occupied ? 'red' : 'green' }}-800 dark:text-{{ $flat->is_occupied ? 'red' : 'green' }}-200">
                        ৳{{ number_format($flat->rent_amount) }}
                    </p>
                    <p class="text-xs text-{{ $flat->is_occupied ? 'red' : 'green' }}-600 dark:text-{{ $flat->is_occupied ? 'red' : 'green' }}-400">
                        per month
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('flats.edit', $flat->id) }}"
            class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary/90 focus:bg-primary focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Flat
        </a>
        @if(!$flat->is_occupied)
            <a href="#" onclick="alert('Tenant assignment feature coming soon!')"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Assign Tenant
            </a>
        @endif
        <a href="{{ route('flats.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Flats
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-12 gap-6">
    <!-- Left Column - Flat Details -->
    <div class="col-span-12 xl:col-span-8">
        <!-- Basic Information Card -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-4">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Property Details
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <!-- Floor -->
                    <div class="text-center p-3 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <div class="text-xl font-bold text-primary mb-1">{{ $flat->floor }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Floor</div>
                    </div>
                    <!-- Bedrooms -->
                    <div class="text-center p-3 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <div class="text-xl font-bold text-primary mb-1">{{ $flat->bedrooms }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Bedroom{{ $flat->bedrooms > 1 ? 's' : '' }}</div>
                    </div>
                    <!-- Bathrooms -->
                    <div class="text-center p-3 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <div class="text-xl font-bold text-primary mb-1">{{ $flat->bathrooms }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Bathroom{{ $flat->bathrooms > 1 ? 's' : '' }}</div>
                    </div>
                    <!-- Area -->
                    <div class="text-center p-3 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <div class="text-xl font-bold text-primary mb-1">{{ $flat->area_sqft ? number_format($flat->area_sqft) : '--' }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Sq Ft</div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Building</span>
                        <span class="text-black dark:text-white">{{ $flat->building->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Location</span>
                        <span class="text-black dark:text-white">{{ $flat->building->city }}, {{ $flat->building->state }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Monthly Rent</span>
                        <span class="text-black dark:text-white font-semibold">
                            {{ $flat->rent_amount ? '৳' . number_format($flat->rent_amount, 2) : 'Not specified' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $flat->is_occupied ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $flat->is_occupied ? 'bg-red-400' : 'bg-green-400' }}"></span>
                            {{ $flat->is_occupied ? 'Occupied' : 'Available' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Tenants Card (if occupied) -->
        @if($flat->is_occupied && $flat->tenants && $flat->tenants->count() > 0)
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-4">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Current Tenants ({{ $flat->tenants->count() }})
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @foreach($flat->tenants as $tenant)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($tenant->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-black dark:text-white">{{ $tenant->name }}</h4>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400 space-x-3">
                                    <span class="flex items-center truncate">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $tenant->email }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $tenant->phone }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Move-in</div>
                            <div class="text-xs font-medium text-black dark:text-white">
                                {{ $tenant->move_in_date ? $tenant->move_in_date->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Owner Information & Building Details -->
    <div class="col-span-12 xl:col-span-4">
        <!-- Owner Information and Building Information Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-1 gap-4 mb-4">
            <!-- Owner Information Card -->
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                    <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Owner Info
                    </h3>
                </div>
                <div class="p-4">
                    @if($flat->owner_name || $flat->owner_phone || $flat->owner_email || $flat->owner_address)
                    <div class="space-y-3">
                        @if($flat->owner_name)
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-black dark:text-white font-medium">{{ $flat->owner_name }}</span>
                        </div>
                        @endif

                        @if($flat->owner_phone)
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $flat->owner_phone }}" class="text-primary hover:underline">{{ $flat->owner_phone }}</a>
                        </div>
                        @endif

                        @if($flat->owner_email)
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $flat->owner_email }}" class="text-primary hover:underline truncate">{{ $flat->owner_email }}</a>
                        </div>
                        @endif

                        @if($flat->owner_address)
                        <div class="flex items-start text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-black dark:text-white line-clamp-2">{{ $flat->owner_address }}</span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">No owner information</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Building Information Card -->
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                    <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Building Info
                    </h3>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Building:</span>
                            <span class="text-black dark:text-white font-medium">{{ $flat->building->name }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Location:</span>
                            <span class="text-black dark:text-white">{{ $flat->building->city }}, {{ $flat->building->state }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Floors:</span>
                                <span class="text-black dark:text-white">{{ $flat->building->total_floors }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ZIP:</span>
                                <span class="text-black dark:text-white">{{ $flat->building->postal_code }}</span>
                            </div>
                        </div>

                        @if($flat->building->description)
                        <div class="text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Description:</span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $flat->building->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Quick Actions
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-2">
                    <a href="{{ route('flats.edit', $flat->id) }}"
                        class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Details
                    </a>

                    <a href="{{ route('buildings.show', $flat->building->id) }}"
                        class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Building Info
                    </a>

                    @if(!$flat->is_occupied)
                    <button onclick="alert('Tenant assignment feature coming soon!')"
                        class="w-full flex items-center justify-center px-3 py-2 border border-transparent rounded-md shadow-sm bg-primary text-xs font-medium text-white hover:bg-primary/90">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Assign Tenant
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
