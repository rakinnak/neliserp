@extends('layouts.app')

@section('content')

<div class="row">
    @include('profiles.left')

    <div class="col-md-9">
        <h4 class="mb-3">{{ __('profiles.account') }}</h4>
        <hr>
        <profile-account-edit inline-template>
            <form method="PATCH" action="/profiles/account" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username">{{ __('users.username') }}</label>
                        <input type="text" class="form-control-plaintext" id="username" name="username" value="{{ auth()->user()->username }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">{{ __('users.name') }}</label>
                        <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
                        <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="first_name">{{ __('users.first_name') }}</label>
                        <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('first_name')}" id="first_name" name="first_name" value="" v-model="form.first_name">
                        <div class="invalid-feedback" v-if="form.errors.has('first_name')" v-text="form.errors.get('first_name')"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="last_name">{{ __('users.last_name') }}</label>
                        <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('last_name')}" id="last_name" name="last_name" value="" v-model="form.last_name">
                        <div class="invalid-feedback" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></div>
                    </div>
                </div>

                <button type="submit" id="submit" class="btn btn-sm btn-primary" :disabled="form.errors.any()">{{ __('update') }}</button>
            </form>
        </profile-account-edit>
    </div>
</div>
@endsection
