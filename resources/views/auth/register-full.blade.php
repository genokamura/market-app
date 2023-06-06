<x-guest-layout>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nickname -->
        <div class="mt-4">
            <x-input-label for="nickname" :value="__('nickname')" />
                <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required autocomplete="nickname" />
                    <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- ZipCode -->
        <div class="mt-4">
            <x-input-label for="zip_code" :value="__('zip_code')" />
                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code')" required autocomplete="zip_code" />
                    <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
        </div>

        <!-- State -->
        <div class="mt-4">
            <x-input-label for="state" :value="__('state')" />
                <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')" required autocomplete="state" />
                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
        </div>
        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('city')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        <!-- Address -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Tel -->
                        <div class="mt-4">
                            <x-input-label for="tel" :value="__('tel')" />
                                <x-text-input id="tel" class="block mt-1 w-full" type="text" name="tel" :value="old('tel')" required autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('tel')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
    </form>
</x-guest-layout>
