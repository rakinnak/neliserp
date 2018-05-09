@extends('layouts.app')

@section('content')

<div class="row">
    @include('profiles.left')

    <div class="col-md-9">
        <h4 class="mb-3">{{ __('profiles.activities') }}</h4>
        <hr>
        <profile-activities-show inline-template>
            <div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('created_at') }}</th>
                            <th>{{ __('subject_type') }}</th>
                            <th>{{ __('subject_id') }}</th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('before') }}</th>
                            <th>{{ __('after') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="activity in activities">
                            <td>@{{ activity.created_at.date }}</td>
                            <td>@{{ activity.subject_type }}</td>
                            <td>@{{ activity.subject_id }}</td>
                            <td>@{{ activity.type }}</td>
                            <td>@{{ activity.before }}</td>
                            <td>@{{ activity.after }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </profile-activities-show>
    </div>
</div>
@endsection
