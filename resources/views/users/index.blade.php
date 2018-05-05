@extends('layouts.app')

@section('content')
<user-index inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('users') }} - {{ __('index') }}</h5>
            <form method="GET" action="/users" id="users-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('users.code') }}/{{ __('users.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/users/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('users.code') }}</th>
                    <th>{{ __('users.name') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && users.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="user in users" :key="user.uuid">
                    <td><a :href="'/users/' + user.uuid">@{{ user.code }}</a></td>
                    <td>@{{ user.name }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</user-index>

@endsection
