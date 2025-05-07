@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Brands') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header">
                @can(Permission::BRAND_CREATE->value)
                    <x-Button.add name="Add Brand" route="{{ route('dashboard.brands.create') }}" />
                @endcan
            </div>

            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.Brand.Sections.indexTable', ['brands' => $brands])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this brand ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
