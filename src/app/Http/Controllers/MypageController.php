<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class MypageController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();

        $sellingItems = Item::where('user_id', $user->id)
                            ->where('status', 'selling')
                            ->with('images')
                            ->get();
                            
        $soldItems = Item::where('user_id', $user->id)
                         ->where('status', 'sold')
                         ->with('images')
                         ->get();

        return view('mypage.index', compact('user', 'sellingItems', 'soldItems'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $items = Item::where('user_id', $id)->with('images')->get();

        return view('mypage.show', compact('user', 'items'));
    }

    public function buy()
    {
        $user = Auth::user();
        $purchasedItems = Order::where('user_id', $user->id)
                               ->with('item.images')
                               ->get()
                               ->pluck('item');
        
        return view('mypage.buy', compact('user', 'purchasedItems'));
    }
}