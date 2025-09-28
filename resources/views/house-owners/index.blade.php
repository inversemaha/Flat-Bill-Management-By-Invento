@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-3xl sm:tracking-tight">
                    House Owner Management
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage property owners and their approval status
                </p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('house-owners.create') }}" 
                   class="ml-3 inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add House Owner
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total House Owners -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total House Owners</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_house_owners'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active House Owners -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active House Owners</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['active_house_owners'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending House Owners -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pending Approval</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['pending_house_owners'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inactive House Owners -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Inactive</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['inactive_house_owners'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- House Owners Table -->
        @if($houseOwners->count() > 0)
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            House Owner
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Building
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Created
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($houseOwners as $houseOwner)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $houseOwner->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        ID: #{{ $houseOwner->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $houseOwner->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($houseOwner->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                @elseif($houseOwner->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 @endif">
                                                {{ ucfirst($houseOwner->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @if($houseOwner->buildings->isNotEmpty())
                                                {{ $houseOwner->buildings->first()->name }}
                                            @else
                                                <span class="text-gray-400">No building assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $houseOwner->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- Conditional Approve Button for Pending Users -->
                                                @if($houseOwner->status === 'pending')
                                                    <button onclick="approveHouseOwner({{ $houseOwner->id }})" 
                                                            class="inline-flex items-center justify-center rounded-md bg-green-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-green-600"
                                                            title="Approve House Owner">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                                
                                                <!-- Standard Action Buttons -->
                                                <a href="{{ route('house-owners.show', $houseOwner) }}" 
                                                   class="inline-flex items-center justify-center rounded-md bg-gray-100 py-1.5 px-3 text-center text-xs font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                                   title="View Details">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('house-owners.edit', $houseOwner) }}" 
                                                   class="inline-flex items-center justify-center rounded-md bg-primary py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-opacity-90"
                                                   title="Edit House Owner">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <!-- Status Toggle Buttons -->
                                                @if($houseOwner->status === 'active')
                                                    <button onclick="deactivateHouseOwner({{ $houseOwner->id }})" 
                                                            class="inline-flex items-center justify-center rounded-md bg-yellow-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-yellow-600"
                                                            title="Deactivate House Owner">
                                                        {{-- X (close) icon --}}
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                @elseif($houseOwner->status === 'inactive')
                                                    <button onclick="reactivateHouseOwner({{ $houseOwner->id }})" 
                                                            class="inline-flex items-center justify-center rounded-md bg-green-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-green-600"
                                                            title="Reactivate House Owner">
                                                        {{-- Checkmark icon --}}
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>

                                                @elseif($houseOwner->status === 'pending')
                                                    <button onclick="approveHouseOwner({{ $houseOwner->id }})" 
                                                            class="inline-flex items-center justify-center rounded-md bg-blue-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-blue-600"
                                                            title="Approve House Owner">
                                                        {{-- Clock icon --}}
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </button>
                                                @endif

                                                
                                                <!-- Delete Button -->
                                                <form action="{{ route('house-owners.destroy', $houseOwner) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this house owner? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center justify-center rounded-md bg-red-500 py-1.5 px-3 text-center text-xs font-medium text-white hover:bg-red-600"
                                                            title="Delete House Owner">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $houseOwners->links() }}
            </div>
        @else
            <div class="mt-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No house owners</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new house owner.</p>
                <div class="mt-6">
                    <a href="{{ route('house-owners.create') }}" 
                       class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add House Owner
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function approveHouseOwner(id) {
    if (confirm('Are you sure you want to approve this house owner?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/house-owners/${id}/approve`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function deactivateHouseOwner(id) {
    if (confirm('Are you sure you want to deactivate this house owner?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/house-owners/${id}/deactivate`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function reactivateHouseOwner(id) {
    if (confirm('Are you sure you want to reactivate this house owner?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/house-owners/${id}/reactivate`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection