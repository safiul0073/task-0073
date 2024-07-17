<x-guest-layout>
    <div class="py-12 ">
        @if (session('success'))
            <x-bladewind::alert type="success">
                {{ session('success') }}
            </x-bladewind::alert>
        @endif
        <form method="post" action="{{ route('user.register') }}" class="mt-6 space-y-6">
            @csrf

            {{-- referral code --}}
            <div>
                <x-input-label for="referral_code" :value="__('Referral Code')" />
                <x-text-input id="referral_code"  name="referral_code" type="text" class="mt-1 block w-full"
                    :value="old('referral_code', request()->input('referrel_code'))" required autocomplete="referral_code" />
                <x-input-error class="mt-2" :messages="$errors->get('referral_code')" />
            </div>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
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

            <div class="flex items-center gap-4">
                <x-bladewind::button can_submit="true" class="mx-auto block">submit</x-bladewind::button>
            </div>
        </form>
    </div>
</x-guest-layout>
