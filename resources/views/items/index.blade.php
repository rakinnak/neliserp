@extends('layouts.app')

@section('content')
<item-list inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('items') }}</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/items/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('items.code') }}</th>
                    <th>{{ __('items.name') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="items.length == 0">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-for="item in items" :key="item.uuid">
                    <td>@{{ item.code }}</td>
                    <td>@{{ item.name }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination')
    </div>
</item-list>

@endsection
