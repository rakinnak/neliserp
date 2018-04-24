<?php

namespace App\Http\Controllers;

use App\Doc;

class DocController extends Controller
{
    public function index($type)
    {
        //$this->authorize('index', Doc::class);

        return view('docs.index', compact('type'));
    }

    public function create($type)
    {
        //$this->authorize('create', Doc::class);

        return view('docs.create', compact('type'));
    }

    public function show($type, $uuid)
    {
        // $this->authorize('show', $doc);

        return view('docs.show', compact('type', 'uuid'));
    }

    public function edit($type, $uuid)
    {
        // $this->authorize('edit', $doc);

        return view('docs.edit', compact('type', 'uuid'));
    }

    public function delete($type, $uuid)
    {
        // $this->authorize('edit', $doc);

        return view('docs.delete', compact('type', 'uuid'));
    }
}
