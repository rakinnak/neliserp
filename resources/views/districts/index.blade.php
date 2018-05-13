@extends('layouts.app')

@section('content')
<district-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/districts" id="districts-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('districts.code') }}/{{ __('districts.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/districts/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('districts.code') }}</th>
                    <th>{{ __('districts.name') }}</th>
                    <th>{{ __('districts.lft') }}</th>
                    <th>{{ __('districts.rgt') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && districts.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="district in districts" :key="district.uuid">
                    <td><a :href="'/districts/' + district.uuid">@{{ district.code }}</a></td>
                    <td>@{{ district.name }}</td>
                    <td>@{{ district.lft }}</td>
                    <td>@{{ district.rgt }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</district-index>

@endsection
