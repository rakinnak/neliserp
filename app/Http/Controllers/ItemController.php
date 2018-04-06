<?php

namespace App\Http\Controllers;

use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        $this->authorize('index', Item::class);

        return view('items.index');
    }
}
