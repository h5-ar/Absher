@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Banners') }}
@endsection
@use('App\Enums\BannerType')
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    @can(Permission::BANNER_CREATE->value)
                        <div class="card-header">
                            <x-Button.add name="Add Banner" route="{{ route('dashboard.banners.create') }}" />
                        </div>
                    @endcan
                    <div class="card-body">
                        <div id="page-data">
                            @include('Dashboard.Admin.Banner.Sections.indexTable', ['banners' => $banners])
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this banner ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
