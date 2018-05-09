@extends('layouts.app')

@section('content')
<location-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/locations" id="locations-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('locations.code') }}/{{ __('locations.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/locations/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('locations.code') }}</th>
                    <th>{{ __('locations.name') }}</th>
                    <th>{{ __('locations.lft') }}</th>
                    <th>{{ __('locations.rgt') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && locations.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="location in locations" :key="location.uuid">
                    <td><a :href="'/locations/' + location.uuid">@{{ location.code }}</a></td>
                    <td>@{{ location.name }}</td>
                    <td>@{{ location.lft }}</td>
                    <td>@{{ location.rgt }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</location-index>

@endsection
