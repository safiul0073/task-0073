<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Money to your Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    <form class="mt-6 space-y-6" action="{{ route('wallet.add.money') }}" method="post" id="payment-form">
                        @csrf
                        <div>
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" type="number" name="amount" type="text"
                                class="mt-1 block w-full" type="number" :value="old('amount')" required autofocus
                                autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>
                        <div>
                            <x-input-label for="currency" :value="__('Currency')" />
                            <x-text-input id="currency" type="number" name="currency" type="text"
                                class="mt-1 block w-full" placeholder="USD" type="text" :value="old('currency')" required autofocus
                                autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-bladewind::button can_submit="true" class="mx-auto block">Add Money</x-bladewind::button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
