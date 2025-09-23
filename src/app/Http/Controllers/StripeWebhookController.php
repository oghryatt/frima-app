<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Event;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret'); 

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => '署名検証失敗'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $item_id = $session->metadata->item_id ?? null;
            $user_id = $session->metadata->user_id ?? null;

            if ($item_id && $user_id) {
                Order::create([
                    'item_id' => $item_id,
                    'user_id' => $user_id,
                    'status'  => 'paid',
                    'stripe_session_id' => $session->id
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
