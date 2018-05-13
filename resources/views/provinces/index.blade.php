@extends('layouts.app')

@section('content')
<province-index inline-template>
    <div>
        @component('header')
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/provinces" id="provinces-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('provinces.code') }}/{{ __('provinces.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/provinces/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        @endcomponent

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('provinces.code') }}</th>
                    <th>{{ __('provinces.name') }}</th>
                    <th>{{ __('provinces.lft') }}</th>
                    <th>{{ __('provinces.rgt') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && provinces.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="province in provinces" :key="province.uuid">
                    <td><a :href="'/provinces/' + province.uuid">@{{ province.code }}</a></td>
                    <td>@{{ province.name }}</td>
                    <td>@{{ province.lft }}</td>
                    <td>@{{ province.rgt }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</province-index>

@endsection
