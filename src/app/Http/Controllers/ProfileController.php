<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $itemsSold = $user->items()->latest()->get();
        $itemsBought = Order::with('item')->where('user_id', $user->id)->latest()->get();

        return view('mypage.profile', [
    'user' => $user,
    'itemsSold' => $itemsSold,
    'itemsBought' => $itemsBought,
    'mode' => 'view',
]);

    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', [
    'user' => $user,
    'mode' => 'edit',
]);

    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/profile_images');
            $user->profile_image = str_replace('public/', 'storage/', $path);
        }

        $user->update([
            'name' => $request->name,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('mypage.profile.show')->with('success', 'プロフィールを更新しました');
    }
}
