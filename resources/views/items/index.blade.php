@extends('layouts.app')

@section('content')
<item-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/items" id="items-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('items.code') }}/{{ __('items.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/items/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        @component('table')
            @slot('thead')
                <tr>
                    <th>{{ __('items.code') }}</th>
                    <th>{{ __('items.name') }}</th>
                </tr>
            @endslot

            @slot('tbody')
                <tr v-for="item in items" :key="item.uuid">
                    <td><a :href="'/items/' + item.uuid">@{{ item.code }}</a></td>
                    <td>@{{ item.name }}</td>
                </tr>
            @endslot
        @endcomponent

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</item-index>

@endsection
