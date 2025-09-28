@extends('layouts.app')

@section('title', 'Edit Tenant - ' . $tenant->name)

@section('content')
<div class="mx-auto max-w-270">
    <!-- Breadcrumb Start -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Edit Tenant: {{ $tenant->name }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-primary" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium text-primary" href="{{ route('tenants.index') }}">Tenants /</a>
                </li>
                <li class="font-medium text-primary">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <!-- Form Start -->
    <form method="POST" action="{{ route('tenants.update', $tenant->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h3>
            </div>
            <div class="p-7">
                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Full Name -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="name">
                            Full Name <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $tenant->name) }}"
                            placeholder="Enter full name"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('name')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="email">
                            Email Address <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $tenant->email) }}"
                            placeholder="Enter email address"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('email')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Phone -->
                    <div class="w-full sm:w-1/4">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="phone">
                            Phone Number <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone', $tenant->phone) }}"
                            placeholder="Enter phone number"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('phone')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="w-full sm:w-1/4">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="date_of_birth">
                            Date of Birth <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="date"
                            name="date_of_birth"
                            id="date_of_birth"
                            value="{{ old('date_of_birth', $tenant->date_of_birth ? $tenant->date_of_birth->format('Y-m-d') : '') }}"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('date_of_birth')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ID Type -->
                    <div class="w-full sm:w-1/4">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="identification_type">
                            ID Type <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <select
                                name="identification_type"
                                id="identification_type"
                                required
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                            >
                                <option value="">Select ID Type</option>
                                <option value="NID" {{ old('identification_type', $tenant->identification_type) == 'NID' ? 'selected' : '' }}>National ID (NID)</option>
                                <option value="Passport" {{ old('identification_type', $tenant->identification_type) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="Driving License" {{ old('identification_type', $tenant->identification_type) == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                            </select>
                        </div>
                        @error('identification_type')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ID Number -->
                    <div class="w-full sm:w-1/4">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="identification_number">
                            ID Number <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="text"
                            name="identification_number"
                            id="identification_number"
                            value="{{ old('identification_number', $tenant->identification_number) }}"
                            placeholder="Enter ID number"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('identification_number')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Flat Selection -->
                    <div class="w-full">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="flat_id">
                            Assign Flat <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <select
                                name="flat_id"
                                id="flat_id"
                                required
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                            >
                                <option value="">Select Available Flat</option>
                                @foreach($availableFlats as $flat)
                                    <option value="{{ $flat->id }}" {{ old('flat_id', $tenant->flat_id) == $flat->id ? 'selected' : '' }}>
                                        {{ $flat->building->name }} - Flat {{ $flat->flat_number }} ({{ $flat->bedrooms }}BR) - ৳{{ number_format($flat->rent_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('flat_id')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-5.5">
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="permanent_address">
                        Permanent Address <span class="text-meta-1">*</span>
                    </label>
                    <textarea
                        name="permanent_address"
                        id="permanent_address"
                        rows="4"
                        placeholder="Enter permanent address"
                        required
                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">{{ old('permanent_address', $tenant->permanent_address) }}</textarea>
                    @error('permanent_address')
                        <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="mb-5.5">
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Tenant Status
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input
                                type="radio"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $tenant->is_active ? 1 : 0) == 1 ? 'checked' : '' }}
                                class="mr-2"
                            />
                            <span class="text-sm text-black dark:text-white">Active</span>
                        </label>
                        <label class="flex items-center">
                            <input
                                type="radio"
                                name="is_active"
                                value="0"
                                {{ old('is_active', $tenant->is_active ? 1 : 0) == 0 ? 'checked' : '' }}
                                class="mr-2"
                            />
                            <span class="text-sm text-black dark:text-white">Inactive</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Lease Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lease Information
                </h3>
            </div>
            <div class="p-7">
                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Lease Start Date -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="lease_start_date">
                            Lease Start Date <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="date"
                            name="lease_start_date"
                            id="lease_start_date"
                            value="{{ old('lease_start_date', $tenant->lease_start_date ? $tenant->lease_start_date->format('Y-m-d') : '') }}"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('lease_start_date')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lease End Date -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="lease_end_date">
                            Lease End Date <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="date"
                            name="lease_end_date"
                            id="lease_end_date"
                            value="{{ old('lease_end_date', $tenant->lease_end_date ? $tenant->lease_end_date->format('Y-m-d') : '') }}"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('lease_end_date')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Monthly Rent -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="monthly_rent">
                            Monthly Rent (৳) <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="number"
                            name="monthly_rent"
                            id="monthly_rent"
                            value="{{ old('monthly_rent', $tenant->monthly_rent) }}"
                            min="0"
                            step="0.01"
                            placeholder="Enter monthly rent"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('monthly_rent')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Security Deposit -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="security_deposit_paid">
                            Security Deposit Paid (৳) <span class="text-meta-1">*</span>
                        </label>
                        <input
                            type="number"
                            name="security_deposit_paid"
                            id="security_deposit_paid"
                            value="{{ old('security_deposit_paid', $tenant->security_deposit_paid) }}"
                            min="0"
                            step="0.01"
                            placeholder="Enter security deposit amount"
                            required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('security_deposit_paid')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact Information -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Emergency Contact Information
                </h3>
            </div>
            <div class="p-7">
                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Emergency Contact Name -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emergency_contact_name">
                            Emergency Contact Name
                        </label>
                        <input
                            type="text"
                            name="emergency_contact_name"
                            id="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}"
                            placeholder="Enter emergency contact name"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('emergency_contact_name')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emergency_contact_phone">
                            Emergency Contact Phone
                        </label>
                        <input
                            type="text"
                            name="emergency_contact_phone"
                            id="emergency_contact_phone"
                            value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}"
                            placeholder="Enter emergency contact phone"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                        />
                        @error('emergency_contact_phone')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- ID Document Upload -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-6">
            <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    ID Document Upload
                </h3>
            </div>
            <div class="p-7">
                <!-- ID Document Image Upload -->
                <div class="mb-5.5">
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="id_document_image">
                        ID Document Image
                    </label>
                    @if($tenant->id_document_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $tenant->id_document_image) }}" alt="Current ID Document" class="max-w-48 rounded-lg border border-stroke">
                            <p class="text-sm text-gray-600 mt-1">Current ID document image</p>
                        </div>
                    @endif
                    <input
                        type="file"
                        name="id_document_image"
                        id="id_document_image"
                        accept="image/*"
                        class="w-full cursor-pointer rounded-lg border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:bg-primary file:text-white hover:file:bg-opacity-90"
                    />
                    <p class="text-sm text-gray-600 mt-1">Upload a clear image of your ID document (NID, Passport, or Driving License). Supported formats: JPG, PNG (Max: 5MB). Leave blank to keep current image.</p>
                    @error('id_document_image')
                        <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4.5">
            <a href="{{ route('tenants.index') }}"
                class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                Cancel
            </a>
            <button type="submit"
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Tenant
            </button>
        </div>
    </form>
    <!-- Form End -->
</div>
@endsection
