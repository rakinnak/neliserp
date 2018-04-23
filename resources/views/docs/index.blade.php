@extends('layouts.app')

@section('content')
<doc-index inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('index') }}</h5>
            <form method="GET" action="/docs" id="docs-search" class="form-inline">
                <label class="mr-2" for="q">{{ __('docs.code') }}/{{ __('docs.name') }}</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/docs/create" class="btn btn-sm btn-outline-success">{{ __('create') }}</a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('docs.code') }}</th>
                    <th>{{ __('docs.name') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="! done">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
                    </td>
                </tr>
                <tr v-if="done && docs.length == 0">
                    <td colspan="2">
                        not found
                    </td>
                </tr>
                <tr v-for="doc in docs" :key="doc.uuid">
                    <td><a :href="'/docs/' + doc.uuid">@{{ doc.code }}</a></td>
                    <td>@{{ doc.name }}</td>
                </tr>
            </tbody>
        </table>

        @include('pagination', ['appends' => ['q' => request('q', '')]])
    </div>
</doc-index>

@endsection
