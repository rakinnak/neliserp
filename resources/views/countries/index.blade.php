@extends('layouts.app')

@section('content')
<country-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/countries" id="countries-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('countries.code') }}/{{ __('countries.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/countries/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('countries.code') }}</th>
                    <th>{{ __('countries.name') }}</th>
                    <th>{{ __('countries.lft') }}</th>
                    <th>{{ __('countries.rgt') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && countries.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="country in countries" :key="country.uuid">
                    <td><a :href="'/countries/' + country.uuid">@{{ country.code }}</a></td>
                    <td>@{{ country.name }}</td>
                    <td>@{{ country.lft }}</td>
                    <td>@{{ country.rgt }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</country-index>

@endsection
