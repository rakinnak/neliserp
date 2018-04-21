@extends('layouts.app')

@section('content')
<form method="POST" action="/items" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="code">{{ __('items.code') }}</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.has('code')}" id="code" name="code" value="" v-model="code">
            <div class="invalid-feedback" v-if="errors.has('code')" v-text="errors.get('code')"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="name">{{ __('items.name') }}</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.has('name')}" id="name" name="name" value="" v-model="name">
            <div class="invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary" :disabled="errors.any()">submit</button>
</form>
@endsection
