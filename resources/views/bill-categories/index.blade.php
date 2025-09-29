@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Bill Categories
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Bill Categories</li>
            </ol>
        </nav>
    </div>

    <!-- Action Button -->
    <div class="mb-6 flex justify-end">
        <a href="{{ route('bill-categories.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6">
            <svg class="fill-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.75 4.75C10.75 4.33579 10.4142 4 10 4C9.58579 4 9.25 4.33579 9.25 4.75V9.25H4.75C4.33579 9.25 4 9.58579 4 10C4 10.4142 4.33579 10.75 4.75 10.75H9.25V15.25C9.25 15.6642 9.58579 16 10 16C10.4142 16 10.75 15.6642 10.75 15.25V10.75H15.25C15.6642 10.75 16 10.4142 16 10C16 9.58579 15.6642 9.25 15.25 9.25H10.75V4.75Z"/>
            </svg>
            Add Category
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
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
        <div class="mb-6 flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
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

    @if ($billCategories->isEmpty())
        <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="py-20">
                <div class="mx-auto max-w-[400px] text-center">
                    <div class="mx-auto mb-6 max-w-[120px]">
                        <svg class="fill-current text-gray-4" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="120" height="120" rx="12" fill="currentColor"/>
                            <path opacity="0.2" d="M60 30C42.5 30 30 42.5 30 60C30 77.5 42.5 90 60 90C77.5 90 90 77.5 90 60C90 42.5 77.5 30 60 30ZM75 67.5H45V52.5H75V67.5ZM75 45H45V30H75V45Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">
                        No Bill Categories Found
                    </h3>
                    <p class="text-base text-body">
                        No bill categories have been created yet. Create your first category to start organizing bills.
                    </p>
                    <a href="{{ route('bill-categories.create') }}" class="mt-6 inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                        <svg class="mr-2 fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.75 4.75C10.75 4.33579 10.4142 4 10 4C9.58579 4 9.25 4.33579 9.25 4.75V9.25H4.75C4.33579 9.25 4 9.58579 4 10C4 10.4142 4.33579 10.75 4.75 10.75H9.25V15.25C9.25 15.6642 9.58579 16 10 16C10.4142 16 10.75 15.6642 10.75 15.25V10.75H15.25C15.6642 10.75 16 10.4142 16 10C16 9.58579 15.6642 9.25 15.25 9.25H10.75V4.75Z"/>
                        </svg>
                        Create First Category
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($billCategories as $category)
            <div class="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-11 w-11 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                            <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.1063 18.0469L19.3875 3.23126C19.2157 1.71876 17.9438 0.584381 16.3969 0.584381H5.56878C4.05628 0.584381 2.78441 1.71876 2.57816 3.23126L0.859406 18.0469C0.756281 18.9063 1.03128 19.7313 1.61566 20.3844C2.20003 21.0375 2.99691 21.3813 3.85628 21.3813H18.1438C19.0031 21.3813 19.8 21.0031 20.3844 20.3844C20.9688 19.7656 21.2438 18.9063 21.1063 18.0469ZM19.2157 19.3531C18.9407 19.6625 18.5625 19.8344 18.1438 19.8344H3.85628C3.4719 19.8344 3.09066 19.6625 2.81566 19.3531C2.54066 19.0438 2.40003 18.6313 2.44378 18.2125L4.16253 3.43751C4.19941 3.09376 4.52191 2.90626 4.90003 2.90626H17.0969C17.4406 2.90626 17.7969 3.06876 17.8338 3.43751L19.5525 18.2125C19.6313 18.6313 19.4906 19.0438 19.2157 19.3531Z" fill=""/>
                                <path d="M14.3345 5.29375C13.922 5.39688 13.647 5.80625 13.7501 6.21562C13.7845 6.42187 13.8189 6.59375 13.8189 6.80000C13.8189 8.35313 12.547 9.625 11.0001 9.625C9.45327 9.625 8.1814 8.35313 8.1814 6.80000C8.1814 6.59375 8.21577 6.42187 8.25015 6.21562C8.35327 5.80625 8.07827 5.39688 7.66890 5.29375C7.25952 5.19063 6.85015 5.46563 6.74702 5.875C6.67827 6.1875 6.64390 6.46875 6.64390 6.80000C6.64390 9.20000 8.60015 11.1563 11.0001 11.1563C13.4001 11.1563 15.3564 9.20000 15.3564 6.80000C15.3564 6.46875 15.322 6.1875 15.2533 5.875C15.1501 5.46563 14.7408 5.19063 14.3345 5.29375Z" fill=""/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-black dark:text-white">
                                {{ $category->name }}
                            </h4>
                            <span class="text-sm text-body">Bill Category</span>
                        </div>
                    </div>
                    @php
                        $statusConfig = $category->is_active
                            ? ['class' => 'bg-success bg-opacity-10 text-success', 'text' => 'Active']
                            : ['class' => 'bg-danger bg-opacity-10 text-danger', 'text' => 'Inactive'];
                    @endphp
                    <span class="inline-flex rounded-full {{ $statusConfig['class'] }} py-1 px-3 text-sm font-medium">
                        {{ $statusConfig['text'] }}
                    </span>
                </div>

                @if($category->description)
                    <p class="text-body mb-5">
                        {{ Str::limit($category->description, 100) }}
                    </p>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-sm text-body">Total Bills</span>
                        <h4 class="text-xl font-bold text-black dark:text-white">
                            {{ $category->bills_count ?? 0 }}
                        </h4>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-body">Created</span>
                        <p class="text-sm font-medium text-black dark:text-white">
                            {{ $category->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center space-x-3.5">
                        <a href="{{ route('bill-categories.show', $category->id) }}"
                            class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                            title="View Details">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        </a>
                        <a href="{{ route('bill-categories.edit', $category->id) }}"
                            class="inline-flex items-center justify-center rounded-md bg-primary py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-opacity-90"
                            title="Edit Building">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('bill-categories.destroy', $category->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-body">Last updated</span>
                        <p class="text-xs text-black dark:text-white">
                            {{ $category->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
