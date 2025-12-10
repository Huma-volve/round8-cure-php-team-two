@extends('dashboard')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.doctor.store') }}">
                        @csrf

                        <!-- Name (Full Width) -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Row: Email | Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row: Gender | Specialty -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Gender (Radio Buttons) -->
                            <div>
                                <x-input-label :value="__('Gender')" class="mb-1" />
                                <div class="flex items-center gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="male" class="text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                        <span class="ml-2">{{ __('Male') }}</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="female" class="text-pink-600 border-gray-300 focus:ring-pink-500" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                        <span class="ml-2">{{ __('Female') }}</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <!-- Specialty -->
                            <div>
                                <x-input-label for="specialty_id" :value="__('Specialty')" />
                                <select id="specialty_id" name="specialty_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Specialty</option>
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('specialty_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row: Password | Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ms-4">
                                {{ __('Create Doctor') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
