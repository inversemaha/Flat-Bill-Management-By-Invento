@extends('layouts.app')

@section('title', 'Edit Flat - ' . $flat->flat_number)

@section('content')
<div class="mx-auto max-w-270">
    <!-- Breadcrumb Start -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Edit Flat: {{ $flat->flat_number }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-primary" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li>
                    <a class="font-medium text-primary" href="{{ route('flats.index') }}">Flats /</a>
                </li>
                <li class="font-medium text-primary">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <!-- Form Start -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Flat Information
                </span>
                <a href="{{ route('flats.index') }}"
                   class="inline-flex items-center justify-center rounded-md bg-meta-3 py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Flats
                </a>
            </h3>
        </div>

        <div class="p-7">
            <form method="POST" action="{{ route('flats.update', $flat->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Building Selection -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="building_id">
                            Building <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="building_id" id="building_id" required
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                                <option value="">Select Building</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id', $flat->building_id) == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }} - {{ $building->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('building_id')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Flat Number -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="flat_number">
                            Flat Number <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="flat_number" id="flat_number" value="{{ old('flat_number', $flat->flat_number) }}" required
                            placeholder="Enter flat number"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                        @error('flat_number')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Floor Number -->
                    <div class="w-full sm:w-1/3">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="floor">
                            Floor Number <span class="text-meta-1">*</span>
                        </label>
                        <input type="number" name="floor" id="floor" value="{{ old('floor', $flat->floor) }}"
                            min="0" max="100" required placeholder="0"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                        @error('floor')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bedrooms -->
                    <div class="w-full sm:w-1/3">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="bedrooms">
                            Bedrooms <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="bedrooms" id="bedrooms" required
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                                <option value="">Select Bedrooms</option>
                                <option value="1" {{ old('bedrooms', $flat->bedrooms) == '1' ? 'selected' : '' }}>1 Bedroom</option>
                                <option value="2" {{ old('bedrooms', $flat->bedrooms) == '2' ? 'selected' : '' }}>2 Bedrooms</option>
                                <option value="3" {{ old('bedrooms', $flat->bedrooms) == '3' ? 'selected' : '' }}>3 Bedrooms</option>
                                <option value="4" {{ old('bedrooms', $flat->bedrooms) == '4' ? 'selected' : '' }}>4 Bedrooms</option>
                                <option value="5" {{ old('bedrooms', $flat->bedrooms) == '5' ? 'selected' : '' }}>5 Bedrooms</option>
                            </select>
                        </div>
                        @error('bedrooms')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bathrooms -->
                    <div class="w-full sm:w-1/3">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="bathrooms">
                            Bathrooms <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="bathrooms" id="bathrooms" required
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                                <option value="">Select Bathrooms</option>
                                <option value="1" {{ old('bathrooms', $flat->bathrooms) == '1' ? 'selected' : '' }}>1 Bathroom</option>
                                <option value="2" {{ old('bathrooms', $flat->bathrooms) == '2' ? 'selected' : '' }}>2 Bathrooms</option>
                                <option value="3" {{ old('bathrooms', $flat->bathrooms) == '3' ? 'selected' : '' }}>3 Bathrooms</option>
                                <option value="4" {{ old('bathrooms', $flat->bathrooms) == '4' ? 'selected' : '' }}>4 Bathrooms</option>
                            </select>
                        </div>
                        @error('bathrooms')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <!-- Area -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="area_sqft">
                            Area (Square Feet)
                        </label>
                        <input type="number" name="area_sqft" id="area_sqft" value="{{ old('area_sqft', $flat->area_sqft) }}"
                            min="1" max="10000" placeholder="1200"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                        @error('area_sqft')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rent Amount -->
                    <div class="w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="rent_amount">
                            Monthly Rent (৳)
                        </label>
                        <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount', $flat->rent_amount) }}"
                            min="0" step="0.01" placeholder="15000"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                        @error('rent_amount')
                            <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Owner Information -->
                <div class="border-t border-stroke pt-6 dark:border-strokedark">
                    <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">Owner Information (Optional)</h4>

                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <!-- Owner Name -->
                        <div class="w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="owner_name">
                                Owner Name
                            </label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $flat->owner_name) }}"
                                placeholder="Enter owner's full name"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                            @error('owner_name')
                                <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Owner Phone -->
                        <div class="w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="owner_phone">
                                Owner Phone
                            </label>
                            <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone', $flat->owner_phone) }}"
                                placeholder="+880 1234567890"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                            @error('owner_phone')
                                <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <!-- Owner Email -->
                        <div class="w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="owner_email">
                                Owner Email
                            </label>
                            <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email', $flat->owner_email) }}"
                                placeholder="owner@example.com"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                            @error('owner_email')
                                <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Owner Address -->
                        <div class="w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="owner_address">
                                Owner Address
                            </label>
                            <textarea name="owner_address" id="owner_address" rows="3"
                                placeholder="Enter owner's address"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">{{ old('owner_address', $flat->owner_address) }}</textarea>
                            @error('owner_address')
                                <p class="mt-2 text-sm text-meta-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4.5">
                    <a href="{{ route('flats.index') }}"
                        class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                        <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Flat
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Form End -->
</div>
@endsection
