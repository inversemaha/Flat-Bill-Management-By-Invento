@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('house-owners.index') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 10h-1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H3a1 1 0 01-1-1v-6H1a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">House Owner Management</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Create House Owner</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-4 text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:tracking-tight">
                Create New House Owner
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Add a new property owner to the system (will be set as pending approval)
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <form method="POST" action="{{ route('house-owners.store') }}" class="px-4 py-6 sm:p-8">
                @csrf

                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <!-- Name -->
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-6">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="sm:col-span-3">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="sm:col-span-3">
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <!-- Hidden Role Field -->
                    <input type="hidden" name="role" value="house_owner">

                    <!-- Info Box -->
                    <div class="sm:col-span-6">
                        <div class="rounded-md bg-blue-50 dark:bg-blue-900/30 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1 md:flex md:justify-between">
                                    <p class="text-sm text-blue-700 dark:text-blue-300">
                                        The house owner will be created with "Pending" status and will need admin approval before they can access the system.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-x-6">
                    <a href="{{ route('house-owners.index') }}" 
                       class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Create House Owner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection