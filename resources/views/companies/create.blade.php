@extends('layouts.app')

@section('content')
<company-create inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('companies') }} - {{ __('create') }}</h5>
        </div>
        <form method="POST" action="/companies" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            @include('companies.form', ['action' => 'create'])
            <button type="submit" id="submit" class="btn btn-primary" :disabled="form.errors.any()">{{ __('submit') }}</button>
        </form>
    </div>        
</company-create>
@endsection
