@extends('layouts.app')

@section('content')
<partner-create inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('partners') }} - {{ __('create') }}</h5>
        </div>
        <form method="POST" action="/partners" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            @include('partners.form', ['action' => 'create'])
            <button type="submit" id="submit" class="btn btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
        </form>
    </div>        
</partner-create>
@endsection
