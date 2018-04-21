@extends('layouts.app')

@section('content')
<form method="POST" action="/items" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="code">{{ __('items.code') }}</label>
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('code')}" id="code" name="code" value="" v-model="form.code">
            <div class="invalid-feedback" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="name">{{ __('items.name') }}</label>
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">submit</button>
</form>
@endsection
