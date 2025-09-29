@extends('layouts.app')

@section('title', auth()->user()->isAdmin() ? 'House Owners Management' : 'My Building')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        @if(auth()->user()->isAdmin())
            Buildings
        @else
            My Building
        @endif
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">
                @if(auth()->user()->isAdmin())
                    Building
                @else
                    My Building
                @endif
            </li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
    <div class="max-w-full overflow-x-auto">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                @if(auth()->user()->isAdmin())
                    Buildings
                @else
                    Building Information
                @endif
            </h4>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('buildings.create') }}"
               class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Building
            </a>
            @elseif(auth()->user()->isHouseOwner() && $buildings->isEmpty())
            <a href="{{ route('buildings.create') }}"
               class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Setup My Building
            </a>
            @endif
        </div>

        @if ($buildings->isEmpty())
            <!-- Empty State -->
            <div class="rounded-sm border border-stroke bg-white py-20 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="text-center">
                    <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center dark:bg-gray-800">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    @if(auth()->user()->isAdmin())
                    <h3 class="mb-2 text-xl font-semibold text-black dark:text-white">No house owners found</h3>
                    <p class="mb-6 text-gray-500 dark:text-gray-400">Get started by creating house owner accounts and their buildings.</p>
                    <a href="{{ route('buildings.create') }}"
                       class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        Create First House Owner
                    </a>
                    @else
                    <h3 class="mb-2 text-xl font-semibold text-black dark:text-white">No building setup</h3>
                    <p class="mb-6 text-gray-500 dark:text-gray-400">Set up your building information to start managing flats and tenants.</p>
                    <a href="{{ route('buildings.create') }}"
                       class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        Setup My Building
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
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Building Details</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Address</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Floors</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Flats</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-sm dark:text-gray-400">Occupancy</p>
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
                            @foreach ($buildings as $building)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block font-medium text-black text-sm dark:text-white/90">{{ $building->name }}</span>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">Building ID: #{{ $building->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div>
                                            <p class="text-gray-800 text-sm dark:text-gray-200">{{ $building->address }}</p>
                                            <p class="text-gray-500 text-xs dark:text-gray-400">{{ $building->city }}, {{ $building->state }} {{ $building->postal_code }}</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                            {{ $building->total_floors }} Floors
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 text-sm font-medium dark:text-gray-200">{{ $building->flats_count ?? 0 }} Total</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @php
                                            $total = $building->flats_count ?? 0;
                                            $occupied = $building->occupied_flats_count ?? 0;
                                            $percentage = $total > 0 ? round(($occupied / $total) * 100) : 0;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $occupied }}/{{ $total }}</span>
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
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('buildings.show', $building->id) }}"
                                               class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                               title="View Details">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                            <a href="{{ route('buildings.edit', $building->id) }}"
                                               class="inline-flex items-center justify-center rounded-md bg-primary py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-opacity-90"
                                               title="Edit Building">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('buildings.destroy', $building->id) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this building? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-md bg-red-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-red-600"
                                                        title="Delete Building">
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
