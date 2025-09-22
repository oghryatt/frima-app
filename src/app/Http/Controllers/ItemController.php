<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Item::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if (Auth::check()) {
            $query->where('user_id', '<>', Auth::id());
        }

        $items = $query->latest()->get();

        return view('items.index', [
            'items' => $items,
            'search' => $search,
        ]);
    }

    public function mylist(Request $request)
    {
        $search = $request->input('search');

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $items = $user->likes()
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('title', 'like', "%{$search}%");
                }
            })
            ->latest()
            ->get();

        return view('items.mylist', [
            'items' => $items,
            'search' => $search,
        ]);
    }

    public function mypage()
    {
        $user = Auth::user();
        $myItems = $user->items()->latest()->get();

        return view('mypage.index', [
            'user' => $user,
            'items' => $myItems,
        ]);
    }

    public function show($id)
    {
        $item = Item::with([
            'user',
            'brand',
            'categories',
            'likes',
            'comments.user',
            'images',
        ])->findOrFail($id);

        $isLiked = Auth::check() ? $item->likes->contains(Auth::id()) : false;

        return view('item', [
            'item' => $item,
            'isLiked' => $isLiked,
            'likeCount' => $item->likes->count(),
            'commentCount' => $item->comments->count(),
        ]);
    }

    public function toggleLike($id)
    {
        $item = Item::findOrFail($id);
        $item->likes()->toggle(Auth::id());

        return back();
    }

    public function addComment(CommentRequest $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('comment'),
        ]);

        return back();
    }
}
