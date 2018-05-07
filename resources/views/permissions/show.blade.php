@extends('layouts.app')

@section('content')
<permission-show :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('permissions') }} - {{ __('show') }}</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    {{--
                    <a href="/permissions/{{ $uuid }}/edit" class="btn btn-sm btn-outline-success">{{ __('edit') }}</a>
                    <a href="/permissions/{{ $uuid }}/delete" class="btn btn-sm btn-outline-danger">{{ __('delete') }}</a>
                    --}}
                </div>
            </div>
        </div>
        <form>
            @include('permissions.form', ['action' => 'show'])
        </form>
    </div>
</permission-show>
@endsection
