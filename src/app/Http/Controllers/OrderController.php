<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order;

class OrderController extends Controller
{
    public function confirm($item_id)
    {
        $item = Item::with(['images'])->findOrFail($item_id);
        $user = Auth::user();

        // 商品がすでに購入済みの場合は詳細ページへ戻す
        if ($item->status === 'sold') {
            return redirect()->route('item.show', $item_id)->with('error', 'この商品はすでに購入されています。');
        }

        return view('buy', [
            'item' => $item,
            'user' => $user,
            'shippingAddress' => $user->address ?? '未設定',
            'selectedMethod' => session('payment_method', 'コンビニ支払い'),
        ]);
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // 自分の出品商品を購入しようとした場合の防止処理
        if ($item->user_id === $user->id) {
            return back()->with('error', '自分の出品した商品は購入できません。');
        }

        // 商品がすでに購入済みの場合の防止処理
        if ($item->status === 'sold') {
            return redirect()->route('item.show', $item_id)->with('error', 'この商品はすでに購入されています。');
        }

        $request->validate([
            'payment_method' => 'required|in:コンビニ支払い,カード支払い',
        ]);

        if ($request->payment_method === 'カード支払い') {
                    session(['payment_method' => 'カード支払い']);

                    return redirect()->route('purchase.card', ['item_id' => $item->id]);
                }


        // 購入処理
        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'shipping_address' => $user->address,
        ]);
        
        $item->update(['status' => 'sold']);

        return redirect()->route('mypage.buy')->with('message', '購入が完了しました！');
    }
}
