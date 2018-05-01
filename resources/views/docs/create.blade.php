@extends('layouts.app')

@section('content')
<doc-create :type="'{{ $type }}'" :input='{!! json_encode($input) !!}' inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('create') }} {{ __('docs.' . $type) }}</h5>
        </div>
        <form method="POST" action="/docs" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" @change="form.errors.clear($event.target.name)">
            @include('docs.form', ['action' => 'create', 'input' => $input])
            <button type="submit" id="submit" class="btn btn-sm btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
            <a href="/docs/{{ $type }}" class="btn btn-sm btn-outline-dark">cancel</a>
        </form>
    </div>        
</doc-create>
@endsection
