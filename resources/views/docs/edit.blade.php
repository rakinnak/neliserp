@extends('layouts.app')

@section('content')
<doc-edit :partner_role="'{{ $partner_role }}'" :type="'{{ $type }}'" :uuid="'{{ $uuid }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('edit') }}</h5>
        </div>
        <form method="PATCH" action="/docs/{{ $type }}/{{ $uuid }}" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" @change="form.errors.clear($event.target.name)">
            @include('docs.form', ['action' => 'edit'])
            <button type="submit" id="submit" class="btn btn-sm btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/docs/{{ $type }}/{{ $uuid }}" class="btn btn-sm btn-outline-dark">cancel</a>
        </form>
    </div>
</doc-edit>
@endsection
