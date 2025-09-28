<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Flat') }}
            </h2>
            <a href="{{ route('flats.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Flats
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('flats.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Building Selection -->
                            <div>
                                <label for="building_id" class="block text-sm font-medium text-gray-700">
                                    Building <span class="text-red-500">*</span>
                                </label>
                                <select name="building_id" id="building_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                                <label for="flat_number" class="block text-sm font-medium text-gray-700">
                                    Flat Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="flat_number" id="flat_number" value="{{ old('flat_number') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('flat_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Floor Number -->
                            <div>
                                <label for="floor" class="block text-sm font-medium text-gray-700">
                                    Floor Number <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="floor" id="floor" value="{{ old('floor') }}"
                                    min="0" max="100" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('floor')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bedrooms -->
                            <div>
                                <label for="bedrooms" class="block text-sm font-medium text-gray-700">
                                    Bedrooms <span class="text-red-500">*</span>
                                </label>
                                <select name="bedrooms" id="bedrooms" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                                <label for="bathrooms" class="block text-sm font-medium text-gray-700">
                                    Bathrooms <span class="text-red-500">*</span>
                                </label>
                                <select name="bathrooms" id="bathrooms" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                                <label for="area_sqft" class="block text-sm font-medium text-gray-700">
                                    Area (Square Feet)
                                </label>
                                <input type="number" name="area_sqft" id="area_sqft" value="{{ old('area_sqft') }}"
                                    min="1" max="10000"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('area_sqft')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rent Amount -->
                            <div>
                                <label for="rent_amount" class="block text-sm font-medium text-gray-700">
                                    Monthly Rent (৳)
                                </label>
                                <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount') }}"
                                    min="0" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('rent_amount')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Owner Information -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Owner Information (Optional)</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Owner Name -->
                                <div>
                                    <label for="owner_name" class="block text-sm font-medium text-gray-700">
                                        Owner Name
                                    </label>
                                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('owner_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Owner Phone -->
                                <div>
                                    <label for="owner_phone" class="block text-sm font-medium text-gray-700">
                                        Owner Phone
                                    </label>
                                    <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('owner_phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <!-- Owner Email -->
                                <div>
                                    <label for="owner_email" class="block text-sm font-medium text-gray-700">
                                        Owner Email
                                    </label>
                                    <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('owner_email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Owner Address -->
                                <div>
                                    <label for="owner_address" class="block text-sm font-medium text-gray-700">
                                        Owner Address
                                    </label>
                                    <textarea name="owner_address" id="owner_address" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('owner_address') }}</textarea>
                                    @error('owner_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('flats.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Flat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
