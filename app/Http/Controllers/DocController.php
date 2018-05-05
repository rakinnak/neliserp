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

        $partner_role = $this->getPartnerRole($type);

        if (session('input')) {
            $input = session('input');
            unset($input['_method']);
            unset($input['_token']);
        } else {
            $input = [
                'company_code' => '',
                'doc_items' => [],
            ];
        }

        return view('docs.create', compact('type', 'input', 'partner_role'));
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

    public function move()
    {
        // $this->authorize('edit', $doc);

        $input = request()->all();

        return redirect()->action('DocController@create', ['type' => $input['destination_type']])
            ->with('input', $input);
    }

    protected function getPartnerRole($doc_type)
    {
        $doc_partner_roles = [
            'so' => 'customer',
            'do' => 'customer',
            'si' => 'customer',
            'po' => 'supplier',
            'ro' => 'supplier',
            'ri' => 'supplier',
        ];

        return $doc_partner_roles[$doc_type];
    }
}
