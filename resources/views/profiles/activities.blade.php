@extends('layouts.app')

@section('content')

<div class="row">
    @include('profiles.left')

    <div class="col-md-9">
        <h4 class="mb-3">{{ __('profiles.activities') }}</h4>
        <hr>
        ..
    </div>
</div>
@endsection
