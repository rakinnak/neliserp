@extends('layouts.app')

@section('content')
<city-edit :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('edit') }}</h5>
        </div>
        <form method="PATCH" action="/cities/{{ $uuid }}" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            @include('cities.form', ['action' => 'edit'])
            <button type="submit" id="submit" class="btn btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/cities/{{ $uuid }}" class="btn btn-light">cancel</a>
        </form>
    </div>
</city-edit>
@endsection
