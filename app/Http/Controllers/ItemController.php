<?php

namespace App\Http\Controllers;

use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Item::class);

        return view('items.index');
    }

    public function create()
    {
        //$this->authorize('create', Item::class);

        return view('items.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $item);

        return view('items.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $item);

        return view('items.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $item);

        return view('items.delete', compact('uuid'));
    }
}
