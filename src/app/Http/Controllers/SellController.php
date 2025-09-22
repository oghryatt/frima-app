<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        return view('sell.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(SellRequest $request)
    {
        // 商品登録
        $item = Item::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'condition' => $request->input('condition'),
            'user_id' => Auth::id(),
            'status' => 'on_sale', // 初期状態：販売中
        ]);

        // カテゴリ（多対多）
        $item->categories()->sync($request->input('categories', []));

        // 画像保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('item_images', 'public'); // storage/public/item_images

                $item->images()->create([
                    'path' => $path, // basename() を使わずフルパスで保存
                ]);
            }
        }

        return redirect()->route('mypage.index')->with('status', '商品を出品しました！');
    }
}
