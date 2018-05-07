@extends('layouts.app')

@section('content')

<div class="row">
    @include('profiles.left')

    <div class="col-md-9">
        <h4 class="mb-3">{{ __('profiles.password') }}</h4>
        <hr>
        <form method="PATCH" action="#">
            {{-- @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" --}}

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="old_password">{{ __('users.old_password') }}</label>
                    <input type="password" class="form-control">
                    {{--
                    :class="{'is-invalid': form.errors.has('old_password')}" id="old_password" name="old_password" value="" v-model="form.old_password">
                    --}}

                    {{--
                    <div class="invalid-feedback" v-if="form.errors.has('old_password')" v-text="form.errors.get('old_password')"></div>
                    --}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="password">{{ __('users.password') }}</label>
                    <input type="password" class="form-control">
                    {{--
                    :class="{'is-invalid': form.errors.has('password')}" id="password" name="password" value="" v-model="form.password">
                    --}}

                    {{--
                    <div class="invalid-feedback" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></div>
                    --}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="password_confirmation">{{ __('users.password_confirmation') }}</label>
                    <input type="password" class="form-control">
                    {{--
                    :class="{'is-invalid': form.errors.has('password_confirmation')}" id="password_confirmation" name="password_confirmation" value="" v-model="form.password_confirmation">
                    --}}

                    {{--
                    <div class="invalid-feedback" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></div>
                    --}}
                </div>
            </div>

            <button type="submit" id="submit" class="btn btn-sm btn-primary">{{ __('update') }}</button>
            {{-- :disabled="form.errors.any()" --}}
        </form>
    </div>
</div>
@endsection
