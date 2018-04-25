@extends('layouts.app')

@section('content')
<doc-show :uuid="'{{ $uuid }}'" :type="'{{ $type }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('show') }}</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/docs/{{ $type }}/{{ $uuid }}/edit" class="btn btn-sm btn-outline-success">{{ __('edit') }}</a>
                    <a href="/docs/{{ $type }}/{{ $uuid }}/delete" class="btn btn-sm btn-outline-danger">{{ __('delete') }}</a>
                </div>
            </div>
        </div>
        <form>
            @include('docs.form', ['action' => 'show'])

            <a href="/docs/{{ $type }}" class="btn btn-outline-dark">back</a>
        </form>
    </div>
</doc-show>
@endsection
