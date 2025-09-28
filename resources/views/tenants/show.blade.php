@extends('layouts.app')

@section('title', 'Tenant Details - ' . $tenant->name)

@section('content')
<div class="mx-auto max-w-270">
    <!-- Breadcrumb Start -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Tenant Details
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-primary" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium text-primary" href="{{ route('tenants.index') }}">Tenants /</a>
                </li>
                <li class="font-medium text-primary">{{ $tenant->name }}</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <!-- Header with Status -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
        <div class="px-7 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary">
                        <span class="text-white font-semibold text-xl">{{ strtoupper(substr($tenant->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-black dark:text-white">{{ $tenant->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if($tenant->flat && $tenant->flat->building)
                                Tenant at {{ $tenant->flat->building->name }} - Flat {{ $tenant->flat->flat_number }}
                            @else
                                No flat assigned
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @if($tenant->is_active)
                        <span class="rounded-full bg-success px-3 py-1 text-sm font-medium text-white">
                            Active Tenant
                        </span>
                    @else
                        <span class="rounded-full bg-meta-1 px-3 py-1 text-sm font-medium text-white">
                            Inactive
                        </span>
                    @endif

                    @if($tenant->lease_end_date)
                        @php
                            $endDate = \Carbon\Carbon::parse($tenant->lease_end_date);
                            $daysLeft = $endDate->diffInDays(now());
                        @endphp
                        @if($endDate->isPast())
                            <span class="rounded-full bg-meta-1 px-3 py-1 text-sm font-medium text-white">
                                Lease Expired
                            </span>
                        @elseif($daysLeft <= 30)
                            <span class="rounded-full bg-warning px-3 py-1 text-sm font-medium text-white">
                                {{ $daysLeft }} days left
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

        <!-- Personal Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Full Name</p>
                        <p class="text-sm font-medium text-black dark:text-white">{{ $tenant->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email Address</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Phone Number</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->phone ?? 'Not provided' }}</p>
                    </div>
                    @if($tenant->permanent_address)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Address</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->permanent_address }}</p>
                    </div>
                    @endif
                    @if($tenant->identification_type && $tenant->identification_number)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Identification</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->identification_type }}: {{ $tenant->identification_number }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Current Property -->
        @if($tenant->flat)
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Current Property
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Flat Number</p>
                        <p class="text-sm font-medium text-black dark:text-white">{{ $tenant->flat->flat_number }}</p>
                    </div>
                    @if($tenant->flat->building)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Building</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->flat->building->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Location</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->flat->building->city }}, {{ $tenant->flat->building->state }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Floor</p>
                        <p class="text-sm text-black dark:text-white">Floor {{ $tenant->flat->floor }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Configuration</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->flat->bedrooms }}BR, {{ $tenant->flat->bathrooms }}BA</p>
                    </div>
                    @if($tenant->flat->area_sqft)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Area</p>
                        <p class="text-sm text-black dark:text-white">{{ number_format($tenant->flat->area_sqft) }} sq ft</p>
                    </div>
                    @endif
                </div>
                <div class="mt-3 pt-3 border-t border-stroke dark:border-strokedark">
                    <a href="{{ route('flats.show', $tenant->flat->id) }}"
                       class="text-xs font-medium text-primary hover:underline">
                        View Flat Details →
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white">Current Property</h3>
            </div>
            <div class="p-4">
                <div class="text-center py-6">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No flat assigned</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Lease Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lease Information
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    @if($tenant->lease_start_date)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lease Start</p>
                        <p class="text-sm text-black dark:text-white">{{ \Carbon\Carbon::parse($tenant->lease_start_date)->format('M d, Y') }}</p>
                    </div>
                    @endif
                    @if($tenant->lease_end_date)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lease End</p>
                        <p class="text-sm text-black dark:text-white">{{ \Carbon\Carbon::parse($tenant->lease_end_date)->format('M d, Y') }}</p>
                        @php
                            $endDate = \Carbon\Carbon::parse($tenant->lease_end_date);
                            $daysLeft = $endDate->diffInDays(now());
                        @endphp
                        @if($endDate->isPast())
                            <p class="text-xs text-meta-1">Expired {{ $endDate->diffForHumans() }}</p>
                        @else
                            <p class="text-xs text-success">{{ $endDate->diffForHumans() }}</p>
                        @endif
                    </div>
                    @endif
                    @if($tenant->lease_start_date && $tenant->lease_end_date)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lease Duration</p>
                        <p class="text-sm text-black dark:text-white">
                            {{ \Carbon\Carbon::parse($tenant->lease_start_date)->diffInMonths(\Carbon\Carbon::parse($tenant->lease_end_date)) }} months
                        </p>
                    </div>
                    @endif
                    @if($tenant->monthly_rent)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Monthly Rent</p>
                        <p class="text-sm font-semibold text-black dark:text-white">৳{{ number_format($tenant->monthly_rent, 2) }}</p>
                    </div>
                    @endif
                    @if($tenant->security_deposit_paid)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Security Deposit</p>
                        <p class="text-sm text-black dark:text-white">৳{{ number_format($tenant->security_deposit_paid, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        @if($tenant->emergency_contact_name || $tenant->emergency_contact_phone)
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Emergency Contact
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    @if($tenant->emergency_contact_name)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Name</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->emergency_contact_name }}</p>
                    </div>
                    @endif
                    @if($tenant->emergency_contact_phone)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Phone</p>
                        <p class="text-sm text-black dark:text-white">{{ $tenant->emergency_contact_phone }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white">Quick Actions</h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-2">
                    <a href="mailto:{{ $tenant->email }}"
                       class="flex items-center justify-center rounded bg-primary py-2 px-4 text-xs font-medium text-gray hover:bg-opacity-90">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </a>
                    @if($tenant->phone)
                    <a href="tel:{{ $tenant->phone }}"
                       class="flex items-center justify-center rounded bg-success py-2 px-4 text-xs font-medium text-white hover:bg-opacity-90">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Tenant
                    </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('tenants.edit', $tenant->id) }}"
                       class="flex items-center justify-center rounded border border-stroke py-2 px-4 text-xs font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Tenant
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('tenants.index') }}"
           class="inline-flex items-center justify-center rounded-md bg-meta-3 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Tenants
        </a>
    </div>
</div>
@endsection
