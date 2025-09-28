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
                        <a href="{{ route('bill-categories.show', $category->id) }}" class="hover:text-primary" title="View Category">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.2031 8.99981 13.2031C13.1061 13.2031 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.79687 8.99981 4.79687C4.89356 4.79687 2.4748 7.95936 1.85605 8.99999Z" fill=""/>
                                <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
                            </svg>
                        </a>
                        <a href="{{ route('bill-categories.edit', $category->id) }}" class="hover:text-primary" title="Edit Category">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.2031 8.99981 13.2031C13.1061 13.2031 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.79687 8.99981 4.79687C4.89356 4.79687 2.4748 7.95936 1.85605 8.99999Z" fill=""/>
                                <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
                            </svg>
                        </a>
                        <form action="{{ route('bill-categories.destroy', $category->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-danger" title="Delete Category">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z" fill=""/>
                                    <path d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z" fill=""/>
                                    <path d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z" fill=""/>
                                    <path d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.36933 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z" fill=""/>
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
