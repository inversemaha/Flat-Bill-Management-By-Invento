@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            {{ $billCategory->name }} - Details
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium" href="{{ route('bill-categories.index') }}">Bill Categories /</a>
                </li>
                <li class="font-medium text-primary">{{ $billCategory->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('bill-categories.edit', $billCategory->id) }}" class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6">
            <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
            </svg>
            Edit Category
        </a>
        <a href="{{ route('bill-categories.index') }}" class="inline-flex items-center justify-center rounded-md border border-primary py-2 px-4 text-center font-medium text-primary hover:bg-opacity-90 lg:px-6">
            <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
        <!-- Category Details -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Category Information
                </h3>
            </div>
            <div class="p-6.5">
                <div class="mb-5.5 flex items-center gap-4">
                    <div class="h-14 w-14 rounded-full bg-meta-2 flex items-center justify-center dark:bg-meta-4">
                        <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.1063 18.0469L19.3875 3.23126C19.2157 1.71876 17.9438 0.584381 16.3969 0.584381H5.56878C4.05628 0.584381 2.78441 1.71876 2.57816 3.23126L0.859406 18.0469C0.756281 18.9063 1.03128 19.7313 1.61566 20.3844C2.20003 21.0375 2.99691 21.3813 3.85628 21.3813H18.1438C19.0031 21.3813 19.8 21.0031 20.3844 20.3844C20.9688 19.7656 21.2438 18.9063 21.1063 18.0469ZM19.2157 19.3531C18.9407 19.6625 18.5625 19.8344 18.1438 19.8344H3.85628C3.4719 19.8344 3.09066 19.6625 2.81566 19.3531C2.54066 19.0438 2.40003 18.6313 2.44378 18.2125L4.16253 3.43751C4.19941 3.09376 4.52191 2.90626 4.90003 2.90626H17.0969C17.4406 2.90626 17.7969 3.06876 17.8338 3.43751L19.5525 18.2125C19.6313 18.6313 19.4906 19.0438 19.2157 19.3531Z" fill=""/>
                            <path d="M14.3345 5.29375C13.922 5.39688 13.647 5.80625 13.7501 6.21562C13.7845 6.42187 13.8189 6.59375 13.8189 6.80000C13.8189 8.35313 12.547 9.625 11.0001 9.625C9.45327 9.625 8.1814 8.35313 8.1814 6.80000C8.1814 6.59375 8.21577 6.42187 8.25015 6.21562C8.35327 5.80625 8.07827 5.39688 7.66890 5.29375C7.25952 5.19063 6.85015 5.46563 6.74702 5.875C6.67827 6.1875 6.64390 6.46875 6.64390 6.80000C6.64390 9.20000 8.60015 11.1563 11.0001 11.1563C13.4001 11.1563 15.3564 9.20000 15.3564 6.80000C15.3564 6.46875 15.322 6.1875 15.2533 5.875C15.1501 5.46563 14.7408 5.19063 14.3345 5.29375Z" fill=""/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-black dark:text-white">
                            {{ $billCategory->name }}
                        </h4>
                        @php
                            $statusConfig = $billCategory->is_active
                                ? ['class' => 'bg-success bg-opacity-10 text-success', 'text' => 'Active']
                                : ['class' => 'bg-danger bg-opacity-10 text-danger', 'text' => 'Inactive'];
                        @endphp
                        <span class="inline-flex rounded-full {{ $statusConfig['class'] }} py-1 px-3 text-sm font-medium">
                            {{ $statusConfig['text'] }}
                        </span>
                    </div>
                </div>

                @if($billCategory->description)
                    <div class="mb-5.5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Description
                        </label>
                        <p class="text-body">{{ $billCategory->description }}</p>
                    </div>
                @endif

                <div class="mb-5.5 flex flex-wrap gap-4">
                    <div class="flex-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Total Bills
                        </label>
                        <span class="text-xl font-bold text-black dark:text-white">{{ $billCategory->bills->count() }}</span>
                    </div>
                    <div class="flex-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Created
                        </label>
                        <span class="text-sm text-body">{{ $billCategory->created_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                </div>

                <div class="mb-5.5">
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Last Updated
                    </label>
                    <span class="text-sm text-body">{{ $billCategory->updated_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Associated Bills -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Associated Bills ({{ $billCategory->bills->count() }})
                </h3>
            </div>
            <div class="p-6.5">
                @if($billCategory->bills->isEmpty())
                    <div class="py-8 text-center">
                        <div class="mx-auto mb-4 max-w-[60px]">
                            <svg class="fill-current text-gray-4" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.1" width="60" height="60" rx="6" fill="currentColor"/>
                                <path opacity="0.2" d="M30 15C23.75 15 15 23.75 15 30C15 36.25 23.75 45 30 45C36.25 45 45 36.25 45 30C45 23.75 36.25 15 30 15ZM37.5 33.75H22.5V26.25H37.5V33.75Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <h4 class="mb-2 text-lg font-semibold text-black dark:text-white">
                            No Bills Found
                        </h4>
                        <p class="text-sm text-body">
                            This category doesn't have any bills associated with it yet.
                        </p>
                    </div>
                @else
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($billCategory->bills->take(10) as $bill)
                            <div class="mb-4 last:mb-0 rounded border border-stroke p-4 dark:border-strokedark">
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="font-medium text-black dark:text-white">
                                        {{ $bill->tenant->name ?? 'N/A' }}
                                    </h5>
                                    @php
                                        $billStatusConfig = [
                                            'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'text' => 'Pending'],
                                            'paid' => ['class' => 'bg-success bg-opacity-10 text-success', 'text' => 'Paid'],
                                            'overdue' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'text' => 'Overdue']
                                        ];
                                        $billConfig = $billStatusConfig[$bill->status] ?? $billStatusConfig['pending'];
                                    @endphp
                                    <span class="inline-flex rounded-full {{ $billConfig['class'] }} py-1 px-2 text-xs font-medium">
                                        {{ $billConfig['text'] }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-body">
                                    <span>৳{{ number_format($bill->amount, 2) }}</span>
                                    <span>Due: {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        @endforeach

                        @if($billCategory->bills->count() > 10)
                            <div class="mt-4 text-center">
                                <a href="{{ route('bills.index', ['category_id' => $billCategory->id]) }}"
                                   class="text-primary hover:underline text-sm">
                                    View all {{ $billCategory->bills->count() }} bills
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
