<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            // get payment intent id
            $payment = Payment::where('payment_intent_id', $paymentIntent->id)
                ->where('status', 'pending')->first();

            $user = $payment->user;
            $user->balance += $paymentIntent->amount_received / 100;
            $user->save();

            $payment->status = 'success';
            $payment->save();
        }

        return response()->json(['status' => 'success'], 200);
    }
}
