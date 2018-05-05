@extends('layouts.app')

@section('content')
<doc-item-index inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/doc_items/{{ $type }}" id="doc_items-search" class="form-inline">
                <label class="mr-2" for="name">{{ __('doc_items.name') }}</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ request('name') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/docs/{{ $type }}/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('doc_items.doc_name') }}</th>
                    <th>{{ __('doc_items.partner_code') }}</th>
                    <th>{{ __('doc_items.issued_at') }}</th>
                    <th>{{ __('doc_items.item_code') }}</th>
                    <th>{{ __('doc_items.pending_quantity') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="5">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && doc_items.length == 0">
                    <td colspan="5">
                        not found
                    </td>
                </tr>
                <tr v-for="doc_item in doc_items" :key="doc_item.uuid">
                    <td><a :href="'/docs/{{ $type }}/' + doc_item.doc_uuid">@{{ doc_item.doc_name }}</a></td>
                    <td>@{{ doc_item.doc_partner_code }}</td>
                    <td>@{{ doc_item.doc_issued_at }}</td>
                    <td>@{{ doc_item.item_code }}</td>
                    <td>@{{ doc_item.pending_quantity }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['name' => request('name')]])
    </div>
</doc-item-index>

@endsection
