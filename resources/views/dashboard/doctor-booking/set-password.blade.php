@include('layouts.admin.inc.head')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="container my-5 mx-auto p-5 border rounded shadow" style="max-width: 400px;">

    
    <form method="POST" action="{{ route('doctor.set-password') }}">
        @csrf
        @method('post')
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            

            <x-primary-button class="ms-3 bg-primary hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 rounded-2 ">
                {{ __('Set Password') }}
            </x-primary-button>
        </div>
    </form>