@extends('layouts.app')

@section('title', 'Flats Management')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            {{ $title ?? 'Flats Management' }}
        </h2>
        @if(isset($subtitle))
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Flats</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
    <div class="max-w-full overflow-x-auto">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h4 class="text-xl font-semibold text-black dark:text-white">
                    {{ $title ?? (auth()->user()->isAdmin() ? 'All Flats' : 'My Flats') }}
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">({{ count($flats) }} {{ count($flats) == 1 ? 'flat' : 'flats' }})</span>
                </h4>

                <!-- Filter Status Indicator -->
                @if(isset($filter) && $filter !== 'all')
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Filtered by:</span>
                    @php
                        $filterConfig = [
                            'occupied' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400', 'text' => 'Occupied Flats'],
                            'vacant' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400', 'text' => 'Vacant Flats']
                        ];
                        $config = $filterConfig[$filter] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => 'All Flats'];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                        {{ $config['text'] }}
                    </span>
                    <a href="{{ route('flats.index') }}" class="text-xs text-primary hover:underline">Clear Filter</a>
                </div>
                @endif
            </div>

            <!-- Quick Filter & Add Button -->
            <div class="flex items-center gap-3">
                <!-- Quick Filter Buttons -->
                @if(!isset($filter) || $filter === 'all')
                <div class="flex items-center gap-2">
                    <a href="{{ route('flats.index', ['filter' => 'occupied']) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium border border-red-200 text-red-700 bg-red-50 hover:bg-red-100 dark:border-red-800 dark:text-red-400 dark:bg-red-900/10 dark:hover:bg-red-900/20">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Occupied
                    </a>
                    <a href="{{ route('flats.index', ['filter' => 'vacant']) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium border border-green-200 text-green-700 bg-green-50 hover:bg-green-100 dark:border-green-800 dark:text-green-400 dark:bg-green-900/10 dark:hover:bg-green-900/20">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2v8h12V6H4z" clip-rule="evenodd"/>
                        </svg>
                        Vacant
                    </a>
                </div>
                @endif

                <a href="{{ route('flats.create') }}"
                   class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Flat
                </a>
            </div>
        </div>

        @if ($flats->isEmpty())
            <!-- Empty State -->
            <div class="rounded-sm border border-stroke bg-white py-20 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="text-center">
                    <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center dark:bg-gray-800">
                        @if(isset($filter))
                            @if($filter === 'occupied')
                                <svg class="h-8 w-8 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            @elseif($filter === 'vacant')
                                <svg class="h-8 w-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2v8h12V6H4z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v2zm0 0h18m-9 2v6"></path>
                                </svg>
                            @endif
                        @else
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v2zm0 0h18m-9 2v6"></path>
                            </svg>
                        @endif
                    </div>

                    @php
                        $emptyStateConfig = [
                            'occupied' => [
                                'title' => 'No occupied flats found',
                                'message' => 'All your flats are currently available for rent. Great opportunity to find new tenants!'
                            ],
                            'vacant' => [
                                'title' => 'No vacant flats found',
                                'message' => 'All your flats are currently occupied. Excellent occupancy rate!'
                            ],
                            'all' => [
                                'title' => 'No flats found',
                                'message' => 'Start by creating flats in your buildings to manage tenants and rental properties.'
                            ]
                        ];
                        $config = $emptyStateConfig[$filter ?? 'all'] ?? $emptyStateConfig['all'];
                    @endphp

                    <h3 class="mb-2 text-xl font-semibold text-black dark:text-white">{{ $config['title'] }}</h3>
                    <p class="mb-6 text-gray-500 dark:text-gray-400">{{ $config['message'] }}</p>

                    @if($filter && $filter !== 'all')
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('flats.index') }}"
                               class="inline-flex items-center justify-center rounded-md bg-gray-100 py-3 px-6 text-center font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                View All Flats
                            </a>
                            @if($filter === 'vacant')
                                <a href="{{ route('flats.create') }}"
                                   class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                                    Add New Flat
                                </a>
                            @endif
                        </div>
                    @else
                        <a href="{{ route('flats.create') }}"
                           class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                            Create Your First Flat
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
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Flat Details</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Building</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Type & Size</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Financials</p>
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
                            @foreach ($flats as $flat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
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
                                            <p class="text-gray-800 text-sm font-medium dark:text-gray-200">
                                                {{ $flat->building->name ?? 'N/A' }}
                                            </p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">
                                                {{ $flat->building->city ?? '' }}{{ $flat->building->city && $flat->building->state ? ', ' : '' }}{{ $flat->building->state ?? '' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                                {{ $flat->flat_type }}
                                            </span>
                                            @if($flat->square_feet)
                                                <p class="text-gray-500 text-xs dark:text-gray-400 mt-1">
                                                    {{ $flat->square_feet }} sq ft
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <p class="text-gray-800 text-sm font-medium dark:text-gray-200">
                                                ৳{{ number_format($flat->rent_amount, 0) }}/month
                                            </p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">
                                                Deposit: ৳{{ number_format($flat->security_deposit, 0) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($flat->tenant)
                                            <div class="space-y-1">
                                                <span class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                                                    Occupied
                                                </span>
                                                <p class="text-gray-500 text-xs dark:text-gray-400">
                                                    {{ $flat->tenant->name }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                Available
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('flats.show', $flat->id) }}"
                                               class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                               title="View Details">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('flats.edit', $flat->id) }}"
                                               class="inline-flex items-center justify-center rounded-md bg-primary py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-opacity-90"
                                               title="Edit Flat">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('flats.destroy', $flat->id) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this flat? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-md bg-red-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-red-600"
                                                        title="Delete Flat">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
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
