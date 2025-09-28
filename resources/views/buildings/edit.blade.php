@extends('layouts.app')

@section('title', 'Edit Building')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Edit Building: {{ $building->name }}
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route('buildings.index') }}">Buildings /</a>
            </li>
            <li class="font-medium text-primary">Edit</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
        <h3 class="font-medium text-black dark:text-white">
            Building Information
        </h3>
    </div>
    <form method="POST" action="{{ route('buildings.update', $building->id) }}">
        @csrf
        @method('PUT')
        <div class="p-6.5">
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- Building Name -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Building Name <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $building->name) }}"
                        placeholder="Enter building name"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('name')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Floors -->
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Total Floors <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="number"
                        name="total_floors"
                        id="total_floors"
                        value="{{ old('total_floors', $building->total_floors) }}"
                        placeholder="Enter total floors"
                        min="1"
                        max="100"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('total_floors')
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
                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">{{ old('address', $building->address) }}</textarea>
                @error('address')
                    <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- City, State, Postal Code -->
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                <!-- City -->
                <div class="w-full xl:w-1/3">
                    <label class="mb-2.5 block text-black dark:text-white">
                        City <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="city"
                        id="city"
                        value="{{ old('city', $building->city) }}"
                        placeholder="Enter city"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('city')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div class="w-full xl:w-1/3">
                    <label class="mb-2.5 block text-black dark:text-white">
                        State <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="state"
                        id="state"
                        value="{{ old('state', $building->state) }}"
                        placeholder="Enter state"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('state')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postal Code -->
                <div class="w-full xl:w-1/3">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Postal Code <span class="text-meta-1">*</span>
                    </label>
                    <input
                        type="text"
                        name="postal_code"
                        id="postal_code"
                        value="{{ old('postal_code', $building->postal_code) }}"
                        placeholder="Enter postal code"
                        required
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                    />
                    @error('postal_code')
                        <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="mb-2.5 block text-black dark:text-white">
                    Description
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Enter description (optional)"
                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">{{ old('description', $building->description) }}</textarea>
                @error('description')
                    <p class="text-meta-1 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4.5">
                <button
                    type="submit"
                    class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                >
                    Update Building
                </button>
                <a
                    href="{{ route('buildings.index') }}"
                    class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
                >
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
