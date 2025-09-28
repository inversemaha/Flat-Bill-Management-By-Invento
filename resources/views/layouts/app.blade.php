<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
        />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FlatManager') }} - @yield('title', 'eCommerce Dashboard')</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- ApexCharts for dashboard charts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body
        x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
        x-init="
            darkMode = JSON.parse(localStorage.getItem('darkMode'));
            $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark bg-gray-900': darkMode === true}"
    >
        <!-- ===== Preloader Start ===== -->
        @include('layouts.preloader')
        <!-- ===== Preloader End ===== -->                <!-- ===== Page Wrapper Start ===== -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- ===== Sidebar Start ===== -->
            <div
                class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
                :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
            >
                @include('layouts.sidebar')
            </div>
            <!-- ===== Sidebar End ===== -->

            <!-- Mobile menu overlay -->
            <div
                x-show="sidebarToggle"
                @click="sidebarToggle = false"
                class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
                style="display: none;"
            ></div>

            <!-- ===== Main Content Area Start ===== -->
            <div class="min-h-screen lg:ml-72">
                <!-- ===== Header Start ===== -->
                <div class="sticky top-0 z-30 bg-white dark:bg-gray-800 shadow-sm">
                    @include('layouts.header')
                </div>
                <!-- ===== Header End ===== -->

                <!-- ===== Main Content Start ===== -->
                <main class="p-4 md:p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-4 rounded-sm border border-green-200 bg-green-50 px-6 py-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-green-500">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-green-800">Success</h5>
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 rounded-sm border border-red-200 bg-red-50 px-6 py-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-red-500">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-red-800">Error</h5>
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="mb-4 rounded-sm border border-yellow-200 bg-yellow-50 px-6 py-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-500">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-yellow-800">Warning</h5>
                                    <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="mb-4 rounded-sm border border-blue-200 bg-blue-50 px-6 py-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-blue-800">Information</h5>
                                    <p class="text-sm text-blue-700">{{ session('info') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </main>
                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Main Content Area End ===== -->
        </div>

        @stack('scripts')
    </body>
</html>
