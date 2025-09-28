@extends('layouts.app')

@section('title', 'Bill Details')

@section('content')
<div class="mx-auto max-w-270">
    <!-- Breadcrumb Start -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Bill Details
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-primary" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium text-primary" href="{{ route('bills.index') }}">Bills /</a>
                </li>
                <li class="font-medium text-primary">{{ $bill->billCategory->name ?? 'Bill' }}</li>
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
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-black dark:text-white">{{ $bill->billCategory->name ?? 'Bill' }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if($bill->flat && $bill->flat->building)
                                {{ $bill->flat->building->name }} - Flat {{ $bill->flat->flat_number }}
                            @else
                                Bill #{{ $bill->id }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @php
                        $statusConfig = [
                            'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'text' => 'Pending'],
                            'paid' => ['class' => 'bg-success bg-opacity-10 text-success', 'text' => 'Paid'],
                            'unpaid' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'text' => 'Unpaid'],
                            'partial' => ['class' => 'bg-info bg-opacity-10 text-info', 'text' => 'Partial'],
                            'overdue' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'text' => 'Overdue']
                        ];
                        $config = $statusConfig[$bill->status] ?? $statusConfig['pending'];
                    @endphp
                    <span class="rounded-full {{ $config['class'] }} px-4 py-2 text-sm font-medium">
                        {{ $config['text'] }}
                    </span>

                    @if($bill->isOverdue())
                        <span class="rounded-full bg-danger bg-opacity-10 text-danger px-3 py-1 text-xs font-medium">
                            Overdue
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

        <!-- Bill Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Bill Information
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Category</p>
                        <p class="text-sm font-medium text-black dark:text-white">{{ $bill->billCategory->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Bill Period</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->month }}/{{ $bill->year }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Due Date</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->due_date ? $bill->due_date->format('F j, Y') : 'Not set' }}</p>
                    </div>
                    @if($bill->paid_date)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Paid Date</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->paid_date->format('F j, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Amount Details -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Amount Details
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Base Amount</p>
                        <p class="text-sm font-medium text-black dark:text-white">৳{{ number_format($bill->amount, 2) }}</p>
                    </div>
                    @if($bill->due_amount > 0)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Due Amount</p>
                        <p class="text-sm text-danger">৳{{ number_format($bill->due_amount, 2) }}</p>
                    </div>
                    @endif
                    <div class="border-t pt-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Amount</p>
                        <p class="text-lg font-bold text-black dark:text-white">৳{{ number_format($bill->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property & Tenant Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Property & Tenant
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-3">
                    @if($bill->flat)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Building</p>
                        <p class="text-sm font-medium text-black dark:text-white">{{ $bill->flat->building->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Flat Number</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->flat->flat_number }}</p>
                    </div>
                    @endif
                    @if($bill->tenant)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Tenant</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->tenant->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Contact</p>
                        <p class="text-sm text-black dark:text-white">{{ $bill->tenant->phone }}</p>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">No tenant assigned</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($bill->notes || $bill->payment_details)
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-3 px-5 dark:border-strokedark">
                <h3 class="text-sm font-semibold text-black dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Additional Information
                </h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-4">
                    @if($bill->notes)
                    <div>
                        <h4 class="text-sm font-medium text-black dark:text-white mb-2">Notes</h4>
                        <p class="text-sm text-body">{{ $bill->notes }}</p>
                    </div>
                    @endif
                    @if($bill->payment_details)
                    <div>
                        <h4 class="text-sm font-medium text-black dark:text-white mb-2">Payment Details</h4>
                        <p class="text-sm text-body">{{ $bill->payment_details }}</p>
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
                    @if(auth()->user()->isAdmin() || auth()->user()->role === 'house_owner')
                    <a href="{{ route('bills.edit', $bill->id) }}"
                       class="flex items-center justify-center rounded bg-primary py-2 px-4 text-xs font-medium text-gray hover:bg-opacity-90">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Bill
                    </a>
                    @endif
                    @if($bill->tenant && $bill->tenant->email)
                    <a href="mailto:{{ $bill->tenant->email }}?subject=Bill {{ $bill->billCategory->name }} - {{ $bill->month }}/{{ $bill->year }}"
                       class="flex items-center justify-center rounded bg-success py-2 px-4 text-xs font-medium text-white hover:bg-opacity-90">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Tenant
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('bills.index') }}"
           class="inline-flex items-center justify-center rounded-md bg-meta-3 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bills
        </a>
    </div>
</div>
@endsection
