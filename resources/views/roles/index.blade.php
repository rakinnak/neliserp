@extends('layouts.app')

@section('content')
<role-index inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('roles') }} - {{ __('index') }}</h5>
            <form method="GET" action="/roles" id="roles-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('roles.code') }}/{{ __('roles.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/roles/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('roles.code') }}</th>
                    <th>{{ __('roles.name') }}</th>
                    <th>{{ __('roles.permissions') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && roles.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="role in roles" :key="role.uuid">
                    <td><a :href="'/roles/' + role.uuid">@{{ role.code }}</a></td>
                    <td>@{{ role.name }}</td>
                    <td>
                        <ul>
                            <li v-for="permission in role.permissions" v-text="permission.code"></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</role-index>

@endsection
