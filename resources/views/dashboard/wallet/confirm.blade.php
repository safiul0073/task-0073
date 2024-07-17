<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Money to your Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form class="mt-6 space-y-6" id="payment-form">
                        <div class="form-row">
                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                            </div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-bladewind::button can_submit="true" class="mx-auto block">Confirm</x-bladewind::button>
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

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                stripe.confirmCardPayment('{{ $clientSecret }}', {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: 'Customer Name'
                        }
                    }
                }).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            alert('Payment successful!');
                            window.location.href = "{{ route('dashboard') }}";
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
