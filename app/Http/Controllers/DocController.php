<?php

namespace App\Http\Controllers;

use App\Doc;

class DocController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Doc::class);

        return view('docs.index');
    }

    public function create()
    {
        //$this->authorize('create', Doc::class);

        return view('docs.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $doc);

        return view('docs.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $doc);

        return view('docs.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $doc);

        return view('docs.delete', compact('uuid'));
    }
}
