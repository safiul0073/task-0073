<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Gift') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-bladewind::alert type="success">
            {{ session('success') }}
        </x-bladewind::alert>
    @endif
    @if (session('error'))
        <x-bladewind::alert type="error">
            {{ session('error') }}
        </x-bladewind::alert>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Send Gift To your referrer') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Enter the amount you want to send and it will be sent to your referrer') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('gifts.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" type="number" name="amount" type="text"
                                    class="mt-1 block w-full" :value="old('amount')" required autofocus
                                    autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-bladewind::button can_submit="true" class="mx-auto block">Send</x-bladewind::button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
