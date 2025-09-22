<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\StripeService;

class PurchaseController extends Controller
{
    public function card($item_id, StripeService $stripe)
    {
        $item = Item::findOrFail($item_id);

        $session = $stripe->createCheckoutSession($item);

        return redirect($session->url);
    }

    public function success()
    {
        return redirect()->route('mypage.buy')->with('message', 'カード決済が完了しました！');
    }

    public function cancel()
    {
        return redirect()->route('item.show')->with('error', 'カード決済がキャンセルされました。');
    }
}
