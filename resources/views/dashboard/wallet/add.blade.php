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
                        <div class="w-full">
                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                            </div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-bladewind::button can_submit="true" class="mx-auto block">Add Money</x-bladewind::button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        </script>
    @endpush
</x-app-layout>
