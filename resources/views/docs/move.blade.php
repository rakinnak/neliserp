@extends('layouts.app')

@section('content')
<doc-move :uuid="'{{ $uuid }}'" :type="'{{ $type }}'" inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>{{ __('move') }}</h5>
        </div>
        <form>
            @include('docs.form', ['action' => 'move'])

            <a href="/docs/{{ $type }}/{{ $uuid }}" class="btn btn-sm btn-outline-dark">cancel</a>
        </form>
    </div>
</doc-move>
@endsection
