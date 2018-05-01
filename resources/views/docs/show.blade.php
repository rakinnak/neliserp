@extends('layouts.app')

@section('content')
<doc-show :uuid="'{{ $uuid }}'" :type="'{{ $type }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('show') }}</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <template v-if="! doc.moving">
                        <button type="button" class="btn btn-sm btn-outline-primary" @click="doc.moving = true">{{ __('move') }}</button>
                        <a href="/docs/{{ $type }}/{{ $uuid }}/edit" class="btn btn-sm btn-outline-success">{{ __('edit') }}</a>
                        <a href="/docs/{{ $type }}/{{ $uuid }}/delete" class="btn btn-sm btn-outline-danger">{{ __('delete') }}</a>
                    </template>
                </div>
            </div>
        </div>
        <form method="POST" action="/docs/move">
            @method('PUT')
            @csrf

            @include('docs.form', ['action' => 'show'])

            <template v-if="doc.moving">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="destination_type" id="destination_type">{{ __('move to') }}</label>
                        <select id="destination_type" name="destination_type" class="form-control form-control-sm">
                            <option value="">-- select --</option>
                            <option value="do">{{ __('docs.do') }}</option>
                            <option value="si">{{ __('docs.si') }}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" id="submit" class="btn btn-sm btn-primary">{{ __('submit') }}</button>
                        <button type="button" class="btn btn-sm btn-outline-dark" @click="doc.moving = false">cancel</button>
                    </div>
                </div>

            </template>
            <template v-else>
                <a href="/docs/{{ $type }}" class="btn btn-sm btn-outline-dark">back</a>
            </template>
        </form>
    </div>
</doc-show>
@endsection
