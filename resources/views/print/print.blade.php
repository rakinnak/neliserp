@extends('layouts.app')

@section('content')
<div class="container">
    <p class="btn-toolbar">
        <div class="btn-group">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">{{ __('back') }}</a>
            {{-- <a href="/print/{{ $type }}/{{ $uuid }}/pdf" class="btn btn-sm btn-outline-success">{{ __('download pdf') }}</a> --}}
            {{-- <a href="/docs/{{ $uuid }}/excel" class="btn btn-sm btn-outline-success">{{ __('download excel') }}</a> --}}
        </div>
    </p>
    <iframe id="pdf-frame" src="/print/{{ $type }}/{{ $uuid }}/pdf"></iframe>
</div>
<link href="/css/print.css" rel="stylesheet">

@endsection
