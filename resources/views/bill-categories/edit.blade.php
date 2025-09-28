@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Edit Bill Category
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium" href="{{ route('bill-categories.index') }}">Bill Categories /</a>
                </li>
                <li class="font-medium text-primary">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
        <div class="flex flex-col gap-9">
            <!-- Edit Bill Category Form -->
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Category Information
                    </h3>
                </div>
                <form method="POST" action="{{ route('bill-categories.update', $billCategory->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="p-6.5">
                        <div class="mb-4.5">
                            <label for="name" class="mb-2.5 block text-black dark:text-white">
                                Category Name <span class="text-meta-1">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $billCategory->name) }}"
                                placeholder="Enter category name (e.g., Electricity, Water, Gas)"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                required
                            />
                            @error('name')
                                <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4.5">
                            <label for="description" class="mb-2.5 block text-black dark:text-white">
                                Description
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                placeholder="Enter category description (optional)"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                            >{{ old('description', $billCategory->description) }}</textarea>
                            @error('description')
                                <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="is_active" class="mb-2.5 block text-black dark:text-white">
                                Status
                            </label>
                            <div class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="is_active" id="is_active" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                    <option value="1" {{ old('is_active', $billCategory->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $billCategory->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.8">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            @error('is_active')
                                <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4.5">
                            <a href="{{ route('bill-categories.index') }}" class="flex w-full justify-center rounded border border-stroke py-2 px-6 text-center font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                                Cancel
                            </a>
                            <button type="submit" class="flex w-full justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                                Update Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
