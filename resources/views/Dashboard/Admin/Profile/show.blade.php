@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Profile') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="card shadow">
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Profile.Section.indexTable',['user' => $user])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

