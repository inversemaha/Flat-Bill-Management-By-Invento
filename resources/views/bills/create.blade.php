@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Create New Bill
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium" href="{{ route('bills.index') }}">Bills /</a>
                </li>
                <li class="font-medium text-primary">Create</li>
            </ol>
        </nav>
    </div>

    @if(!$hasActiveTenants)
        <!-- No Tenants Message -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Cannot Create Bill
                </h3>
            </div>
            <div class="p-6.5">
                <div class="flex items-center p-4 mb-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-medium">No Active Tenants Available!</span>
                        <p class="mt-1 text-sm">You need to have active tenants in your flats before you can create bills. Please add tenants to your flats first.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('tenants.create') }}"
                       class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10.75 4.75C10.75 4.33579 10.4142 4 10 4C9.58579 4 9.25 4.33579 9.25 4.75V9.25H4.75C4.33579 9.25 4 9.58579 4 10C4 10.4142 4.33579 10.75 4.75 10.75H9.25V15.25C9.25 15.6642 9.58579 16 10 16C10.4142 16 10.75 15.6642 10.75 15.25V10.75H15.25C15.6642 10.75 16 10.4142 16 10C16 9.58579 15.6642 9.25 15.25 9.25H10.75V4.75Z"/>
                        </svg>
                        Add New Tenant
                    </a>

                    <a href="{{ route('tenants.index') }}"
                       class="inline-flex items-center justify-center rounded-md bg-gray-600 py-3 px-6 text-center font-medium text-white hover:bg-gray-700">
                        <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View All Tenants
                    </a>

                    <a href="{{ route('bills.index') }}"
                       class="inline-flex items-center justify-center rounded-md bg-gray-500 py-3 px-6 text-center font-medium text-white hover:bg-gray-600">
                        Back to Bills
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Bill Creation Form -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Bill Information
                </h3>
            </div>
            <form method="POST" action="{{ route('bills.store') }}" class="p-6.5">
                @csrf

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label for="tenant_id" class="mb-2.5 block text-black dark:text-white">
                            Tenant <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select name="tenant_id" id="tenant_id" required
                                    class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary @error('tenant_id') border-meta-1 @enderror">
                                <option value="">Select Tenant</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} - Flat {{ $tenant->flat->flat_number ?? 'N/A' }} ({{ $tenant->flat->building->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g opacity="0.8">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""/>
                                    </g>
                                </svg>
                            </span>
                        </div>
                        @error('tenant_id')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full xl:w-1/2">
                        <label for="bill_category_id" class="mb-2.5 block text-black dark:text-white">
                            Bill Category <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select name="bill_category_id" id="bill_category_id" required
                                    class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary @error('bill_category_id') border-meta-1 @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('bill_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g opacity="0.8">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""/>
                                    </g>
                                </svg>
                            </span>
                        </div>
                        @error('bill_category_id')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label for="amount" class="mb-2.5 block text-black dark:text-white">
                            Amount <span class="text-meta-1">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" max="999999.99" name="amount" id="amount" value="{{ old('amount') }}" required
                               placeholder="Enter bill amount"
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('amount') border-meta-1 @enderror" />
                        @error('amount')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full xl:w-1/2">
                        <label for="due_date" class="mb-2.5 block text-black dark:text-white">
                            Due Date <span class="text-meta-1">*</span>
                        </label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('due_date') border-meta-1 @enderror" />
                        @error('due_date')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label for="bill_period_start" class="mb-2.5 block text-black dark:text-white">
                            Bill Period Start <span class="text-meta-1">*</span>
                        </label>
                        <input type="date" name="bill_period_start" id="bill_period_start" value="{{ old('bill_period_start') }}" required
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('bill_period_start') border-meta-1 @enderror" />
                        @error('bill_period_start')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full xl:w-1/2">
                        <label for="bill_period_end" class="mb-2.5 block text-black dark:text-white">
                            Bill Period End <span class="text-meta-1">*</span>
                        </label>
                        <input type="date" name="bill_period_end" id="bill_period_end" value="{{ old('bill_period_end') }}" required
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('bill_period_end') border-meta-1 @enderror" />
                        @error('bill_period_end')
                            <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4.5">
                    <label for="late_fee" class="mb-2.5 block text-black dark:text-white">
                        Late Fee (Optional)
                    </label>
                    <input type="number" step="0.01" min="0" max="99999.99" name="late_fee" id="late_fee" value="{{ old('late_fee') }}"
                           placeholder="Enter late fee amount"
                           class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('late_fee') border-meta-1 @enderror" />
                    @error('late_fee')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="mb-2.5 block text-black dark:text-white">
                        Description (Optional)
                    </label>
                    <textarea rows="4" name="description" id="description" placeholder="Enter bill description"
                              class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('description') border-meta-1 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Create Bill
                    </button>
                    <a href="{{ route('bills.index') }}" class="flex w-full justify-center rounded bg-gray-500 p-3 font-medium text-gray hover:bg-opacity-90">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
