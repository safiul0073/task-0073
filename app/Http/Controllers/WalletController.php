<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class WalletController extends Controller
{

    private $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
    }
    public function index()
    {
        return view('dashboard.wallet.add');
    }
    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'currency' => 'required',
        ]);
        
        $user = User::find(auth()->id());

        $payment = $user->payments()->where([
            'status' => 'pending',
            'amount' => (int) $request->amount
        ])->first();

        if ($payment) {
            $payment_intent_id = $payment->payment_intent_id;
            $payment_intent = PaymentIntent::retrieve($payment_intent_id);

            if ($payment_intent->status == 'succeeded') {
                return redirect()->back()->with('success', 'Payment successful');
            }

            return view('dashboard.wallet.confirm', [
                'clientSecret' => $payment_intent->client_secret,
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => $request->currency,
            'metadata' => [
                'user_id' => auth()->id(),
            ],
            'payment_method_types' => ['card'],
        ]);

        $user->payments()->create([
            'payment_intent_id' => $paymentIntent->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => 'pending',
        ]);

        return view('dashboard.wallet.confirm', [
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

}
