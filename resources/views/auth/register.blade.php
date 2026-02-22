<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
                required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role" class="block mt-1 w-full" required>
                <option value="">--Chouse Role--</option>
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}> Customer</option>
                <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')"
                required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="avatar" :value="__('Avatar')" />
            <x-text-input id="avatar" class="block mt-1 w-full" type="text" name="avatar" :value="old('avatar')"
                required autofocus autocomplete="avatar" />
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')" />
            <select name="status" id="status" class="block mt-1 w-full" required>
                <option value="">--Chouse status--</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>inactive</option>
                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>suspended</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="date_of_birth" :value="__('Date of birth')" />
            <x-text-input id="	date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                :value="old('date_of_birth')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="place_of_residence" :value="__('Place of residence')" />
            <x-text-input id="place_of_residence" class="block mt-1 w-full" type="text" name="place_of_residence"
                :value="old('place_of_residence')" required autofocus autocomplete="place_of_residence" />
            <x-input-error :messages="$errors->get('place_of_residence')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />

            <select name="gender" id="gender" class="block mt-1 w-full" required>
                <option value="">--Chouse gender--</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>female</option>

            </select>
        </div>
        <div class="mt-4">
            <x-input-label for="remember_token" :value="__('remember token')" />
            <x-text-input id="remember_token" class="block mt-1 w-full" type="text" name="remember_token"
                :value="old('remember_token')" required autofocus autocomplete="remember_token" />
            <x-input-error :messages="$errors->get('remember_token')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
