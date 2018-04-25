@extends('layouts.app')

@section('content')
<doc-create :type="'{{ $type }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('create') }}</h5>
        </div>
        <form method="POST" action="/docs" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" @change="form.errors.clear($event.target.name)">
            @include('docs.form', ['action' => 'create'])
            <button type="submit" id="submit" class="btn btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/docs/{{ $type }}" class="btn btn-outline-dark">cancel</a>
        </form>
    </div>        
</doc-create>
@endsection
