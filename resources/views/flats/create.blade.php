@extends('layouts.app')

@section('title', 'Create New Flat')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Create New Flat
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route('flats.index') }}">Flats /</a>
            </li>
            <li class="font-medium text-primary">Create</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
    <div class="max-w-full overflow-x-auto">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                Create New Flat
            </h4>
            <a href="{{ route('flats.index') }}"
               class="inline-flex items-center justify-center rounded-md bg-gray-600 py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Flats
            </a>
        </div>

        <form method="POST" action="{{ route('flats.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Building Selection -->
                <div>
                    <label for="building_id" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Building <span class="text-red-500">*</span>
                    </label>
                    <select name="building_id" id="building_id" required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('building_id') border-red-500 @enderror">
                        <option value="">Select Building</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->name }} - {{ $building->city }}
                            </option>
                        @endforeach
                    </select>
                    @error('building_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Flat Number -->
                <div>
                    <label for="flat_number" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Flat Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="flat_number" id="flat_number" value="{{ old('flat_number') }}" required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('flat_number') border-red-500 @enderror">
                    @error('flat_number')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Floor Number -->
                <div>
                    <label for="floor" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Floor Number <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="floor" id="floor" value="{{ old('floor') }}"
                        min="0" max="100" required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('floor') border-red-500 @enderror">
                    @error('floor')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bedrooms -->
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Bedrooms <span class="text-red-500">*</span>
                    </label>
                    <select name="bedrooms" id="bedrooms" required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('bedrooms') border-red-500 @enderror">
                        <option value="">Select Bedrooms</option>
                        <option value="1" {{ old('bedrooms') == '1' ? 'selected' : '' }}>1 Bedroom</option>
                        <option value="2" {{ old('bedrooms') == '2' ? 'selected' : '' }}>2 Bedrooms</option>
                        <option value="3" {{ old('bedrooms') == '3' ? 'selected' : '' }}>3 Bedrooms</option>
                        <option value="4" {{ old('bedrooms') == '4' ? 'selected' : '' }}>4 Bedrooms</option>
                        <option value="5" {{ old('bedrooms') == '5' ? 'selected' : '' }}>5 Bedrooms</option>
                    </select>
                    @error('bedrooms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bathrooms -->
                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Bathrooms <span class="text-red-500">*</span>
                    </label>
                    <select name="bathrooms" id="bathrooms" required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('bathrooms') border-red-500 @enderror">
                        <option value="">Select Bathrooms</option>
                        <option value="1" {{ old('bathrooms') == '1' ? 'selected' : '' }}>1 Bathroom</option>
                        <option value="2" {{ old('bathrooms') == '2' ? 'selected' : '' }}>2 Bathrooms</option>
                        <option value="3" {{ old('bathrooms') == '3' ? 'selected' : '' }}>3 Bathrooms</option>
                        <option value="4" {{ old('bathrooms') == '4' ? 'selected' : '' }}>4 Bathrooms</option>
                    </select>
                    @error('bathrooms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Area -->
                <div>
                    <label for="area_sqft" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Area (Square Feet)
                    </label>
                    <input type="number" name="area_sqft" id="area_sqft" value="{{ old('area_sqft') }}"
                        min="1" max="10000"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('area_sqft') border-red-500 @enderror">
                    @error('area_sqft')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rent Amount -->
                <div>
                    <label for="rent_amount" class="block text-sm font-medium text-black dark:text-white mb-2">
                        Monthly Rent (৳)
                    </label>
                    <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}"
                        min="0" step="0.01"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('rent_amount') border-red-500 @enderror">
                    @error('rent_amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Owner Information -->
            <div class="border-t border-stroke pt-6 dark:border-strokedark">
                <h5 class="mb-4 text-lg font-semibold text-black dark:text-white">Owner Information (Optional)</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-black dark:text-white mb-2">
                            Owner Name
                        </label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('owner_name') border-red-500 @enderror">
                        @error('owner_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Phone -->
                    <div>
                        <label for="owner_phone" class="block text-sm font-medium text-black dark:text-white mb-2">
                            Owner Phone
                        </label>
                        <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('owner_phone') border-red-500 @enderror">
                        @error('owner_phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <!-- Owner Email -->
                    <div>
                        <label for="owner_email" class="block text-sm font-medium text-black dark:text-white mb-2">
                            Owner Email
                        </label>
                        <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('owner_email') border-red-500 @enderror">
                        @error('owner_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Address -->
                    <div>
                        <label for="owner_address" class="block text-sm font-medium text-black dark:text-white mb-2">
                            Owner Address
                        </label>
                        <textarea name="owner_address" id="owner_address" rows="3"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary @error('owner_address') border-red-500 @enderror">{{ old('owner_address') }}</textarea>
                        @error('owner_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('flats.index') }}"
                    class="inline-flex items-center justify-center rounded-md bg-gray-600 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    Create Flat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
