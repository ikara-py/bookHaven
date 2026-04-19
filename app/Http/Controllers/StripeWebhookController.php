<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('STRIPE_SIGNATURE');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                config('services.stripe.webhook_secret')
            );
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $payment = Payment::where('transaction_id', $session->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $session->payment_intent,
            ]);

            $order = $payment->order;
            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'paid']);
                
                $order->load('items.book');
                foreach ($order->items as $item) {
                    $item->book->decrement('stock', $item->quantity);
                }

                app(OrderService::class)->syncOrderStatus($order->id);
            }
        }
    }

    protected function handlePaymentIntentFailed($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update(['status' => 'failed']);
            if ($payment->order) {
                $payment->order->update(['status' => 'failed']);
            }
        }
    }
}
