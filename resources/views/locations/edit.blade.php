@extends('layouts.app')

@section('content')
<location-edit :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('edit') }}</h5>
        </div>
        <form method="PATCH" action="/locations/{{ $uuid }}" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            @include('locations.form', ['action' => 'edit'])
            <button type="submit" id="submit" class="btn btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/locations/{{ $uuid }}" class="btn btn-light">cancel</a>
        </form>
    </div>
</location-edit>
@endsection
