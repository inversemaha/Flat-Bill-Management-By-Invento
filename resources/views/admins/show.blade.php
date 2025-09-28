@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
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
                            <span class="ml-4 text-sm font-medium text-gray-500">{{ $admin->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:tracking-tight">
                        {{ $admin->name }}
                    </h1>
                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            {{ $admin->email }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            System Administrator
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0 md:flex-shrink-0">
                    <a href="{{ route('admins.edit', $admin) }}" 
                       class="ml-3 inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Admin Details -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:px-6">
                        <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Admin Information</h3>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">Account details and status.</p>
                    </div>
                    <div class="border-t border-gray-100 dark:border-gray-700">
                        <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Full name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $admin->name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Email address</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $admin->email }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Role</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-700/10 dark:ring-blue-400/30">
                                        System Administrator
                                    </span>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Status</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                                    <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 dark:ring-green-400/30">
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Created</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $admin->created_at->format('F j, Y \a\t g:i A') }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900 dark:text-white">Last updated</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $admin->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div>
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:px-6">
                        <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Quick Actions</h3>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">Manage this admin account.</p>
                    </div>
                    <div class="border-t border-gray-100 dark:border-gray-700 px-4 py-6 sm:px-6">
                        <div class="space-y-3">
                            <a href="{{ route('admins.edit', $admin) }}" 
                               class="flex w-full items-center justify-center rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Admin
                            </a>
                            <a href="{{ route('admins.index') }}" 
                               class="flex w-full items-center justify-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Admin List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection