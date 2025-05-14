@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Versions') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header">
                @can(Permission::VERSION_CREATE->value)
                    <x-Button.add name="Add Version" route="{{ route('dashboard.versions.create') }}" />
                @endcan
            </div>

            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.Version.Sections.indexTable', ['versions' => $versions])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
