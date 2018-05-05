@extends('layouts.app')

@section('content')
<partner-show :role="'{{ $role }}'" :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __("partners.{$role}") }} - {{ __('show') }}</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <a href="/partners/{{ $role }}/{{ $uuid }}/edit" class="btn btn-sm btn-outline-success">{{ __('edit') }}</a>
                    <a href="/partners/{{ $role }}/{{ $uuid }}/delete" class="btn btn-sm btn-outline-danger">{{ __('delete') }}</a>
                </div>
            </div>
        </div>
        <form>
            @include('partners.form', ['action' => 'show'])
        </form>
    </div>
</partner-show>
@endsection
