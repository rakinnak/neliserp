@extends('layouts.app')

@section('content')
<city-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/cities" id="cities-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('cities.code') }}/{{ __('cities.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/cities/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('cities.code') }}</th>
                    <th>{{ __('cities.name') }}</th>
                    <th>{{ __('cities.lft') }}</th>
                    <th>{{ __('cities.rgt') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && cities.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="city in cities" :key="city.uuid">
                    <td><a :href="'/cities/' + city.uuid">@{{ city.code }}</a></td>
                    <td>@{{ city.name }}</td>
                    <td>@{{ city.lft }}</td>
                    <td>@{{ city.rgt }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</city-index>

@endsection
