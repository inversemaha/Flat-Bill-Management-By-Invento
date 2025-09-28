<!-- SIDEBAR HEADER -->
<div class="flex h-full flex-col overflow-y-auto bg-gray-800 py-4 px-3">
    <div class="flex items-center justify-center mb-8">
        <a href="{{ route('dashboard') }}">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="hidden lg:block">
                    <h1 class="text-xl font-bold text-white">FlatManager</h1>
                    <p class="text-xs text-gray-300">Property Management</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <nav class="flex-1 space-y-1">
        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">MENU</h3>

        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('dashboard') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('dashboard') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
        </ul>

        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 mt-6">PROPERTIES</h3>

        <ul class="space-y-1">
            <!-- Buildings / House Owners -->
            @if(auth()->user()->isAdmin())
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('buildings.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('buildings.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('buildings.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Buildings
                </a>
            </li>
            @elseif(auth()->user()->isHouseOwner())
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('buildings.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('buildings.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('buildings.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0H5m14 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2m14 0V9a2 2 0 00-2-2M5 21V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    My Building
                </a>
            </li>
            @endif

            <!-- Flats -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('flats.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('flats.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('flats.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"></path>
                    </svg>
                    Flats
                </a>
            </li>

            <!-- Tenants (Admin only can create, House owners can view their tenants) -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('tenants.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('tenants.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('tenants.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    </svg>
                    @if(auth()->user()->isAdmin())
                        Tenants
                    @else
                        My Tenants
                    @endif
                </a>
            </li>
        </ul>

        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 mt-6">BILLING</h3>

        <ul class="space-y-1">
            <!-- Bills -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('bills.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('bills.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('bills.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Bills
                </a>
            </li>

            <!-- Categories -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('bill-categories.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('bill-categories.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('bill-categories.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m14 8H5m14 4H5"></path>
                    </svg>
                    Categories
                </a>
            </li>
        </ul>

        @if(auth()->user()->isAdmin())
        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 mt-6">USER MANAGEMENT</h3>

        <ul class="space-y-1">
            <!-- Admin Management -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admins.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('admins.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('admins.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Admin Management
                </a>
            </li>
            
            <!-- House Owner Management -->
            <li>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('house-owners.*') ? 'bg-gray-700 text-white' : '' }}"
                   href="{{ route('house-owners.index') }}">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-white {{ request()->routeIs('house-owners.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    House Owner Management
                </a>
            </li>
        </ul>
        @endif

        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 mt-6">AUTH</h3>

        <ul class="space-y-1">
            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>
