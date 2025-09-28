@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('admins.index') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 10h-1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H3a1 1 0 01-1-1v-6H1a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">Admin Management</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Edit Admin</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-4 text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:tracking-tight">
                Edit Admin: {{ $admin->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update administrator information
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <form method="POST" action="{{ route('admins.update', $admin) }}" class="px-4 py-6 sm:p-8">
                @csrf
                @method('PUT')

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
                                   value="{{ old('name', $admin->name) }}"
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
                                   value="{{ old('email', $admin->email) }}"
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
                            New Password <span class="text-gray-400">(optional)</span>
                        </label>
                        <div class="mt-2">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   placeholder="Leave blank to keep current password"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="sm:col-span-3">
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Confirm New Password
                        </label>
                        <div class="mt-2">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   placeholder="Confirm new password"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <!-- Hidden Role Field -->
                    <input type="hidden" name="role" value="admin">
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-x-6">
                    <a href="{{ route('admins.show', $admin) }}" 
                       class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection