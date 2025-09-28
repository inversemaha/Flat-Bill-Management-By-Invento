@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Bills Management
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Bills</li>
            </ol>
        </nav>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('bills.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6">
                <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.75 4.75C10.75 4.33579 10.4142 4 10 4C9.58579 4 9.25 4.33579 9.25 4.75V9.25H4.75C4.33579 9.25 4 9.58579 4 10C4 10.4142 4.33579 10.75 4.75 10.75H9.25V15.25C9.25 15.6642 9.58579 16 10 16C10.4142 16 10.75 15.6642 10.75 15.25V10.75H15.25C15.6642 10.75 16 10.4142 16 10C16 9.58579 15.6642 9.25 15.25 9.25H10.75V4.75Z"/>
                </svg>
                Create Bill
            </a>

            @if($hasFlatsWithTenants)
                <button onclick="openModal()"
                        class="inline-flex items-center justify-center rounded-md bg-success py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6">
                    <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2ZM13 11H11V13C11 13.5523 10.5523 14 10 14C9.44772 14 9 13.5523 9 13V11H7C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9H9V7C9 6.44772 9.44772 6 10 6C10.5523 6 11 6.44772 11 7V9H13C13.5523 9 14 9.44772 14 10C14 10.5523 13.5523 11 13 11Z"/>
                    </svg>
                    Generate Monthly Bills
                </button>
            @else
                <div class="inline-flex items-center justify-center rounded-md bg-gray-400 py-2 px-4 text-center font-medium text-white cursor-not-allowed lg:px-6" title="Add tenants to flats first">
                    <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2ZM13 11H11V13C11 13.5523 10.5523 14 10 14C9.44772 14 9 13.5523 9 13V11H7C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9H9V7C9 6.44772 9.44772 6 10 6C10.5523 6 11 6.44772 11 7V9H13C13.5523 9 14 9.44772 14 10C14 10.5523 13.5523 11 13 11Z"/>
                    </svg>
                    Generate Monthly Bills
                </div>
            @endif
        </div>
    </div>

    <!-- Filters Card -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
        <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
                Filter Bills
            </h3>
        </div>
        <div class="p-6.5">
            <form method="GET" action="{{ route('bills.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="status" class="mb-2.5 block text-black dark:text-white">
                        Status
                    </label>
                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="status" id="status" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="tenant_id" class="mb-2.5 block text-black dark:text-white">
                        Tenant
                    </label>
                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="tenant_id" id="tenant_id" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="">All Tenants</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="category_id" class="mb-2.5 block text-black dark:text-white">
                        Category
                    </label>
                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="category_id" id="category_id" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="month" class="mb-2.5 block text-black dark:text-white">
                        Month
                    </label>
                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="month" id="month" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="">All Months</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bills Table -->
    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        @if (session('success'))
            <div class="mb-4 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
                <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-[#34D399]">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3355 6.92401 11.035L15.2162 2.11161C15.5833 1.74452 15.576 1.18615 15.2984 0.826822Z" fill="white" stroke="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-semibold text-black dark:text-[#34D399]">
                        Success
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
                <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-[#F87171]">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.4917 7.65579L11.106 12.2645C11.2545 12.4128 11.4715 12.5 11.6738 12.5C11.8762 12.5 12.0931 12.4128 12.2416 12.2645C12.5621 11.9445 12.5623 11.4317 12.2423 11.1114C12.2422 11.1113 12.2422 11.1113 12.2422 11.1113L7.64539 6.50311L12.2589 1.90221C12.4062 1.75477 12.4934 1.53781 12.4934 1.33549C12.4934 1.13317 12.4062 0.916213 12.2589 0.768771C11.9384 0.448589 11.4256 0.448589 11.1051 0.768771L6.4917 5.34931L1.89459 0.747166C1.74715 0.599827 1.53019 0.512695 1.32787 0.512695C1.12555 0.512695 0.908592 0.599827 0.761151 0.747166C0.440969 1.06735 0.440969 1.58016 0.761151 1.90034L5.33169 6.50311L0.745492 11.1084C0.598153 11.2558 0.511021 11.4728 0.511021 11.6751C0.511021 11.8774 0.598153 12.0944 0.745492 12.2418C1.06567 12.562 1.57848 12.562 1.89866 12.2418L6.4917 7.65579Z" fill="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-semibold text-black dark:text-[#F87171]">
                        Error
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif

        @if ($bills->isEmpty())
            <div class="py-20">
                <div class="mx-auto max-w-[400px] text-center">
                    <div class="mx-auto mb-6 max-w-[120px]">
                        <svg class="fill-current text-gray-4" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="120" height="120" rx="12" fill="currentColor"/>
                            <path opacity="0.2" d="M60 30C42.5 30 30 42.5 30 60C30 77.5 42.5 90 60 90C77.5 90 90 77.5 90 60C90 42.5 77.5 30 60 30ZM60 75C55.5 75 52.5 72 52.5 67.5C52.5 63 55.5 60 60 60C64.5 60 67.5 63 67.5 67.5C67.5 72 64.5 75 60 75ZM67.5 52.5H52.5V45H67.5V52.5Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">
                        No Bills Found
                    </h3>
                    <p class="text-base text-body">
                        No bills found with the current filters. Try adjusting your search criteria or create a new bill.
                    </p>
                    <a href="{{ route('bills.create') }}" class="mt-6 inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        <svg class="mr-2 fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.75 4.75C10.75 4.33579 10.4142 4 10 4C9.58579 4 9.25 4.33579 9.25 4.75V9.25H4.75C4.33579 9.25 4 9.58579 4 10C4 10.4142 4.33579 10.75 4.75 10.75H9.25V15.25C9.25 15.6642 9.58579 16 10 16C10.4142 16 10.75 15.6642 10.75 15.25V10.75H15.25C15.6642 10.75 16 10.4142 16 10C16 9.58579 15.6642 9.25 15.25 9.25H10.75V4.75Z"/>
                        </svg>
                        Create First Bill
                    </a>
                </div>
            </div>
        @else
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                Bill Details
                            </th>
                            <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                Tenant & Property
                            </th>
                            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                                Amount
                            </th>
                            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                                Due Date
                            </th>
                            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                                Status
                            </th>
                            <th class="py-4 px-4 font-medium text-black dark:text-white">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $bill)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                <div class="flex flex-col gap-1">
                                    <div class="font-medium text-black dark:text-white">
                                        {{ $bill->billCategory->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-meta-3">
                                        <svg class="mr-1 inline fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875ZM7 12.6875C4.09375 12.6875 1.6875 10.2813 1.6875 7.375C1.6875 4.46875 4.09375 2.0625 7 2.0625C9.90625 2.0625 12.3125 4.46875 12.3125 7.375C12.3125 10.2813 9.90625 12.6875 7 12.6875Z" fill=""/>
                                            <path d="M7.4375 4.09375C7.4375 3.775 7.18125 3.5 6.875 3.5C6.56875 3.5 6.3125 3.775 6.3125 4.09375V7.59375C6.3125 7.7875 6.39375 7.96875 6.53125 8.10625L8.78125 10.3563C9.0125 10.5875 9.39375 10.5875 9.625 10.3563C9.85625 10.125 9.85625 9.74375 9.625 9.5125L7.4375 7.325V4.09375Z" fill=""/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($bill->bill_period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($bill->bill_period_end)->format('M d, Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex flex-col gap-1">
                                    <div class="font-medium text-black dark:text-white">
                                        {{ $bill->tenant->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-meta-3">
                                        <svg class="mr-1 inline fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 5.6875V12.25C13 12.7344 12.6094 13.125 12.125 13.125H1.875C1.39062 13.125 1 12.7344 1 12.25V5.6875C1.4375 5.9375 1.96875 6.125 2.5625 6.125H11.4375C12.0313 6.125 12.5625 5.9375 13 5.6875Z" fill=""/>
                                            <path d="M11.4375 0.875H2.5625C1.5 0.875 0.65625 1.71875 0.65625 2.78125V3.0625C0.65625 3.71875 1.1875 4.25 1.84375 4.25H12.1562C12.8125 4.25 13.3438 3.71875 13.3438 3.0625V2.78125C13.3438 1.71875 12.5 0.875 11.4375 0.875Z" fill=""/>
                                        </svg>
                                        Flat {{ $bill->tenant->flat->flat_number ?? 'N/A' }} - {{ $bill->tenant->flat->building->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex flex-col gap-1">
                                    <div class="font-semibold text-black dark:text-white">
                                        ৳{{ number_format($bill->amount, 2) }}
                                    </div>
                                    @if($bill->late_fee > 0)
                                        <div class="text-sm text-red-500">
                                            <svg class="mr-1 inline fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875ZM9.1875 8.5625C9.1875 8.83594 8.96094 9.0625 8.6875 9.0625H5.3125C5.03906 9.0625 4.8125 8.83594 4.8125 8.5625V6.1875C4.8125 5.91406 5.03906 5.6875 5.3125 5.6875H8.6875C8.96094 5.6875 9.1875 5.91406 9.1875 6.1875V8.5625Z" fill="currentColor"/>
                                            </svg>
                                            Late Fee: ৳{{ number_format($bill->late_fee, 2) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex flex-col gap-1">
                                    <div class="font-medium text-black dark:text-white">
                                        {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}
                                    </div>
                                    @if($bill->status === 'overdue')
                                        <div class="text-sm text-red-500">
                                            <svg class="mr-1 inline fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.125 5.25H7.875V3.5H6.125V5.25ZM6.125 10.5H7.875V6.125H6.125V10.5ZM7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875Z" fill="currentColor"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($bill->due_date)->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex flex-col gap-2">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'M7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875ZM7.875 10.5H6.125V8.75H7.875V10.5ZM7.875 7H6.125V3.5H7.875V7Z'],
                                            'paid' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'M7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875ZM5.65625 9.84375L3.0625 7.25L4.15625 6.15625L5.65625 7.65625L9.84375 3.46875L10.9375 4.5625L5.65625 9.84375Z'],
                                            'overdue' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'M7 0.875C3.42188 0.875 0.5 3.79688 0.5 7.375C0.5 10.9531 3.42188 13.875 7 13.875C10.5781 13.875 13.5 10.9531 13.5 7.375C13.5 3.79688 10.5781 0.875 7 0.875ZM9.40625 8.84375L8.84375 9.40625L7 7.5625L5.15625 9.40625L4.59375 8.84375L6.4375 7L4.59375 5.15625L5.15625 4.59375L7 6.4375L8.84375 4.59375L9.40625 5.15625L7.5625 7L9.40625 8.84375Z']
                                        ];
                                        $config = $statusConfig[$bill->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <p class="inline-flex rounded-full {{ $config['class'] }} py-1 px-3 text-sm font-medium">
                                        <svg class="mr-1 fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="{{ $config['icon'] }}" fill="currentColor"/>
                                        </svg>
                                        {{ ucfirst($bill->status) }}
                                    </p>
                                    @if($bill->paid_date)
                                        <div class="text-xs text-meta-3">
                                            Paid: {{ \Carbon\Carbon::parse($bill->paid_date)->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('bills.show', $bill->id) }}" class="hover:text-primary" title="View Bill">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.2031 8.99981 13.2031C13.1061 13.2031 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.79687 8.99981 4.79687C4.89356 4.79687 2.4748 7.95936 1.85605 8.99999Z" fill=""/>
                                            <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
                                        </svg>
                                    </a>

                                    @if($bill->status !== 'paid')
                                        <form action="{{ route('bills.mark-as-paid', $bill->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="hover:text-success" title="Mark as Paid"
                                                onclick="return confirm('Mark this bill as paid?')">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 1.125C4.64063 1.125 1.125 4.64063 1.125 9C1.125 13.3594 4.64063 16.875 9 16.875C13.3594 16.875 16.875 13.3594 16.875 9C16.875 4.64063 13.3594 1.125 9 1.125ZM7.3125 12.9375L3.9375 9.5625L5.0625 8.4375L7.3125 10.6875L12.9375 5.0625L14.0625 6.1875L7.3125 12.9375Z" fill=""/>
                                                </svg>
                                            </button>
                                        </form>

                                        <a href="{{ route('bills.edit', $bill->id) }}" class="hover:text-primary" title="Edit Bill">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.2031 8.99981 13.2031C13.1061 13.2031 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.79687 8.99981 4.79687C4.89356 4.79687 2.4748 7.95936 1.85605 8.99999Z" fill=""/>
                                                <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this bill?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:text-danger" title="Delete Bill">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z" fill=""/>
                                                    <path d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z" fill=""/>
                                                    <path d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z" fill=""/>
                                                    <path d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.36933 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z" fill=""/>
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
        @endif
    </div>
</div>

<!-- Generate Monthly Bills Modal -->
<div id="generateBillModal" class="fixed inset-0 z-999999 hidden items-center justify-center bg-black bg-opacity-90 px-4 py-5">
    <div class="relative w-full max-w-lg rounded-lg bg-white p-6 dark:bg-boxdark">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-black dark:text-white">
                Generate Monthly Bills
            </h3>
            <button onclick="closeModal()" class="flex h-7 w-7 items-center justify-center rounded-lg border border-stroke hover:bg-gray dark:border-strokedark dark:hover:bg-meta-4" type="button">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.4917 7.65579L11.106 12.2645C11.2545 12.4128 11.4715 12.5 11.6738 12.5C11.8762 12.5 12.0931 12.4128 12.2416 12.2645C12.5621 11.9445 12.5623 11.4317 12.2423 11.1114C12.2422 11.1113 12.2422 11.1113 12.2422 11.1113L7.64539 6.50311L12.2589 1.90221C12.4062 1.75477 12.4934 1.53781 12.4934 1.33549C12.4934 1.13317 12.4062 0.916213 12.2589 0.768771C11.9384 0.448589 11.4256 0.448589 11.1051 0.768771L6.4917 5.34931L1.89459 0.747166C1.74715 0.599827 1.53019 0.512695 1.32787 0.512695C1.12555 0.512695 0.908592 0.599827 0.761151 0.747166C0.440969 1.06735 0.440969 1.58016 0.761151 1.90034L5.33169 6.50311L0.745492 11.1084C0.598153 11.2558 0.511021 11.4728 0.511021 11.6751C0.511021 11.8774 0.598153 12.0944 0.745492 12.2418C1.06567 12.562 1.57848 12.562 1.89866 12.2418L6.4917 7.65579Z" fill="#6B7280"></path>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('bills.generate-monthly') }}">
            @csrf
            <div class="space-y-5.5">
                <div>
                    <label for="gen_month" class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Month <span class="text-meta-1">*</span>
                    </label>
                    <div class="relative z-20 bg-white dark:bg-form-input">
                        <select name="month" id="gen_month" required class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="#637381"></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="gen_year" class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Year <span class="text-meta-1">*</span>
                    </label>
                    <div class="relative z-20 bg-white dark:bg-form-input">
                        <select name="year" id="gen_year" required class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                            @for($i = date('Y'); $i <= date('Y') + 2; $i++)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="#637381"></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="gen_category" class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Bill Category <span class="text-meta-1">*</span>
                    </label>
                    <div class="relative z-20 bg-white dark:bg-form-input">
                        <select name="bill_category_id" id="gen_category" required class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="#637381"></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-7.5 flex gap-4.5">
                <button type="button" onclick="closeModal()" class="flex-1 rounded border border-stroke py-2 px-6 text-center font-medium text-black hover:bg-gray hover:bg-opacity-90 dark:border-strokedark dark:text-white dark:hover:bg-meta-4 dark:hover:bg-opacity-90">
                    Cancel
                </button>
                <button type="submit" class="flex-1 rounded bg-success py-2 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    Generate Bills
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    const modal = document.getElementById('generateBillModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('generateBillModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

@endsection
