@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Categories') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card shadow">
            @can(Permission::CATEGORY_CREATE->value)
                <div class="card-header">
                    <x-Button.add name="Add Category" route="{{ route('dashboard.categories.create') }}" />
                </div>
            @endcan
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Category.Section.indexTable',['categories' => $categories])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this category ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
