@extends('layouts.app')

@section('content')
<company-index inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/companies" id="companies-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('companies.code') }}/{{ __('companies.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/companies/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('companies.code') }}</th>
                    <th>{{ __('companies.name') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && companies.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="company in companies" :key="company.uuid">
                    <td><a :href="'/companies/' + company.uuid">@{{ company.code }}</a></td>
                    <td>@{{ company.name }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</company-index>

@endsection
