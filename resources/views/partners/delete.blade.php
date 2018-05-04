@extends('layouts.app')

@section('content')
<partner-delete :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('partners') }} - {{ __('delete') }}</h5>
        </div>
        <form method="DELETE" action="/partners/{{ $uuid }}" @submit.prevent="onSubmit">
            @include('partners.form', ['action' => 'delete'])
            <button type="submit" id="submit" class="btn btn-danger" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/partners/{{ $uuid }}" class="btn btn-light">cancel</a>
        </form>
    </div>
</partner-delete>
@endsection
