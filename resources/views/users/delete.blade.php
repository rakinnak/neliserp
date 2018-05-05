@extends('layouts.app')

@section('content')
<user-delete :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('users') }} - {{ __('delete') }}</h5>
        </div>
        <form method="DELETE" action="/users/{{ $uuid }}" @submit.prevent="onSubmit">
            @include('users.form', ['action' => 'delete'])
            <button type="submit" id="submit" class="btn btn-danger" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/users/{{ $uuid }}" class="btn btn-light">cancel</a>
        </form>
    </div>
</user-delete>
@endsection
