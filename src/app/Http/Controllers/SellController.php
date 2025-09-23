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
        
        $item = Item::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'condition' => $request->input('condition'),
            'user_id' => Auth::id(),
            'status' => 'on_sale', 
        ]);

       
        $item->categories()->sync($request->input('categories', []));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('item_images', 'public');
                $item->images()->create([
                    'path' => $path, 
                ]);
            }
        }

        return redirect()->route('mypage.index')->with('status', '商品を出品しました！');
    }
}
