<!-- Header Start -->
<div class="w-full bg-white shadow-sm dark:bg-gray-800">
    <div class="flex items-center justify-between px-4 py-4 md:px-6">
        <!-- Left Side Content -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile: Hamburger Toggle BTN -->
            <button class="block rounded-sm border border-gray-300 bg-white p-1.5 shadow-sm dark:border-gray-600 dark:bg-gray-800 lg:hidden"
                    @click.stop="sidebarToggle = !sidebarToggle">
                <span class="relative block h-5 w-5 cursor-pointer">
                    <span class="block absolute right-0 h-full w-full">
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-0 duration-200 ease-in-out dark:bg-white"
                              :class="{ '!w-full delay-300': !sidebarToggle }"></span>
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white"
                              :class="{ '!w-full delay-300': !sidebarToggle }"></span>
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white"
                              :class="{ '!w-full delay-500': !sidebarToggle }"></span>
                    </span>
                    <span class="absolute right-0 h-full w-full rotate-45">
                        <span class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white"
                              :class="{ '!h-0 !delay-0': !sidebarToggle }"></span>
                        <span class="delay-300 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white"
                              :class="{ '!h-0 !delay-200': !sidebarToggle }"></span>
                    </span>
                </span>
            </button>

            <!-- Mobile Logo -->
            <a class="block flex-shrink-0 lg:hidden" href="{{ route('dashboard') }}">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-lg font-bold text-black dark:text-white">FlatManager</span>
                </div>
            </a>

            <!-- Desktop: Page Title or Breadcrumbs -->
            <div class="hidden lg:block">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center gap-3">
            <!-- User Area -->
            <div class="relative" x-data="{ dropdownOpen: false }">
                <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = !dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black dark:text-white">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->isAdmin() ? 'Administrator' : 'House Owner' }}</span>
                    </span>

                    <span class="h-12 w-12 rounded-full">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-500 text-white">
                            <span class="text-lg font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </span>

                    <svg class="hidden fill-current sm:block" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"
                              fill="" />
                    </svg>
                </a>

                <!-- Dropdown Start -->
                <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     class="absolute right-0 mt-4 flex w-48 flex-col rounded-sm border border-gray-200 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-800">

                    <ul class="flex flex-col border-b border-gray-200 px-4 py-4 dark:border-gray-600">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-sm font-medium duration-300 ease-in-out hover:text-primary">
                                <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.28125 2.16562 7.90625 3.50624 7.90625 5.12187C7.90625 6.73749 9.28125 8.07812 11 8.07812C12.7188 8.07812 14.0938 6.73749 14.0938 5.12187C14.0938 3.50624 12.7188 2.16562 11 2.16562Z" fill="" />
                                    <path d="M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0437 20.8656 18.4937 21.4156 17.7719 21.4156ZM4.53748 19.8687H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.50311 14.575 4.50311 17.0844V19.8687H4.53748Z" fill="" />
                                </svg>
                                My Profile
                            </a>
                        </li>
                    </ul>

                    <button class="flex items-center gap-3 px-4 py-3 text-sm font-medium duration-300 ease-in-out hover:text-primary"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M15.5375 0.618744H11.6531C10.7594 0.618744 10.0031 1.37499 10.0031 2.26874V4.64062C10.0031 5.05312 10.3469 5.39687 10.7594 5.39687C11.1719 5.39687 11.5156 5.05312 11.5156 4.64062V2.23437C11.5156 2.16562 11.5844 2.09687 11.6531 2.09687H15.5375C16.3625 2.09687 17.0156 2.75 17.0156 3.575V18.425C17.0156 19.25 16.3625 19.9031 15.5375 19.9031H11.6531C11.5844 19.9031 11.5156 19.8344 11.5156 19.7656V17.3594C11.5156 16.9469 11.1719 16.6031 10.7594 16.6031C10.3469 16.6031 10.0031 16.9469 10.0031 17.3594V19.7313C10.0031 20.625 10.7594 21.3812 11.6531 21.3812H15.5375C17.2219 21.3812 18.5844 20.0187 18.5844 18.3344V3.66562C18.5844 1.98124 17.2219 0.618744 15.5375 0.618744Z" fill="" />
                            <path d="M6.05001 11.7563H12.2031C12.6156 11.7563 12.9594 11.4125 12.9594 11C12.9594 10.5875 12.6156 10.2438 12.2031 10.2438H6.08439L8.21564 8.07813C8.52501 7.76875 8.52501 7.2875 8.21564 6.97812C7.90626 6.66875 7.42501 6.66875 7.11564 6.97812L3.67814 10.4156C3.36876 10.725 3.36876 11.2063 3.67814 11.5156L7.11564 14.9531C7.42501 15.2625 7.90626 15.2625 8.21564 14.9531C8.52501 14.6438 8.52501 14.1625 8.21564 13.8531L6.05001 11.7563Z" fill="" />
                        </svg>
                        Log Out
                    </button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                <!-- Dropdown End -->
            </div>
            <!-- User Area -->
        </div>
    </div>
</div>
<!-- Header End -->
