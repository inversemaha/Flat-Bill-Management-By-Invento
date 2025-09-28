@extends('layouts.app')

@section('title', 'Add New Tenant')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Add New Tenant
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route('tenants.index') }}">Tenants /</a>
            </li>
            <li class="font-medium text-primary">Create</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<form method="POST" action="{{ route('tenants.store') }}">
    @csrf

    <!-- Personal Information -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
        <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
                Personal Information
            </h3>
        </div>
        <div class="p-6.5">
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- Full Name -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Full Name <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Enter full name"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('name')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Email Address <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email address"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('email')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- Phone -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Phone Number <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="{{ old('phone') }}"
                        placeholder="Enter phone number"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('phone')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Flat Selection -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Assign Flat <span class="text-meta-1">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="flat_id"
                            id="flat_id"
                            required
                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white"
                        >
                            <option value="" class="text-body dark:text-bodydark">Select Available Flat</option>
                            @foreach($availableFlats as $flat)
                                <option value="{{ $flat->id }}" {{ old('flat_id') == $flat->id ? 'selected' : '' }} class="text-body dark:text-bodydark">
                                    {{ $flat->building->name }} - Flat {{ $flat->flat_number }} ({{ $flat->flat_type }}) - ৳{{ number_format($flat->rent_amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                    @error('flat_id')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="mb-6">
                <label class="mb-2.5 block text-black dark:text-white">
                    Address <span class="text-meta-1">*</span>
                </label>
                <textarea
                    name="address"
                    id="address"
                    rows="4"
                    placeholder="Enter complete address"
                    required
                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Lease Information -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
        <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
                Lease Information
            </h3>
        </div>
        <div class="p-6.5">
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- Lease Start Date -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Lease Start Date <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="date"
                        name="lease_start_date"
                        id="lease_start_date"
                        value="{{ old('lease_start_date') }}"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('lease_start_date')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lease End Date -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Lease End Date <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="date"
                        name="lease_end_date"
                        id="lease_end_date"
                        value="{{ old('lease_end_date') }}"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('lease_end_date')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6 flex flex-col gap-6 xl:flex-row">
                <!-- Monthly Rent -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Monthly Rent (৳) <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="number"
                        name="monthly_rent"
                        id="monthly_rent"
                        value="{{ old('monthly_rent') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter monthly rent"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('monthly_rent')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Security Deposit -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Security Deposit Paid (৳) <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="number"
                        name="security_deposit_paid"
                        id="security_deposit_paid"
                        value="{{ old('security_deposit_paid') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter security deposit amount"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('security_deposit_paid')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
        <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
                Emergency Contact & Identification
            </h3>
        </div>
        <div class="p-6.5">
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- Emergency Contact Name -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Emergency Contact Name
                    </label>
                    <input
                        type="text"
                        name="emergency_contact_name"
                        id="emergency_contact_name"
                        value="{{ old('emergency_contact_name') }}"
                        placeholder="Enter emergency contact name"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('emergency_contact_name')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emergency Contact Phone -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Emergency Contact Phone
                    </label>
                    <input
                        type="text"
                        name="emergency_contact_phone"
                        id="emergency_contact_phone"
                        value="{{ old('emergency_contact_phone') }}"
                        placeholder="Enter emergency contact phone"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('emergency_contact_phone')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6 flex flex-col gap-6 xl:flex-row">
                <!-- Identification Type -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        ID Type
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="identification_type"
                            id="identification_type"
                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white"
                        >
                            <option value="" class="text-body dark:text-bodydark">Select ID Type</option>
                            <option value="Aadhaar" {{ old('identification_type') == 'Aadhaar' ? 'selected' : '' }} class="text-body dark:text-bodydark">Aadhaar</option>
                            <option value="PAN" {{ old('identification_type') == 'PAN' ? 'selected' : '' }} class="text-body dark:text-bodydark">PAN</option>
                            <option value="Driving License" {{ old('identification_type') == 'Driving License' ? 'selected' : '' }} class="text-body dark:text-bodydark">Driving License</option>
                            <option value="Passport" {{ old('identification_type') == 'Passport' ? 'selected' : '' }} class="text-body dark:text-bodydark">Passport</option>
                            <option value="Voter ID" {{ old('identification_type') == 'Voter ID' ? 'selected' : '' }} class="text-body dark:text-bodydark">Voter ID</option>
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <g opacity="0.8">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                    @error('identification_type')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Identification Number -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        ID Number
                    </label>
                    <input
                        type="text"
                        name="identification_number"
                        id="identification_number"
                        value="{{ old('identification_number') }}"
                        placeholder="Enter ID number"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('identification_number')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4.5">
        <button
            type="submit"
            class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
        >
            Add Tenant
        </button>
        <a
            href="{{ route('tenants.index') }}"
            class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
        >
            Cancel
        </a>
    </div>
</form>
@endsection
