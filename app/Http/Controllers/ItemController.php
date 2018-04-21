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

    public function create()
    {
        $this->authorize('create', Item::class);

        return view('items.create');
    }
}
