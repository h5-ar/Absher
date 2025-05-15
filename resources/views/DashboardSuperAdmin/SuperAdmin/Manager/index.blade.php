@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Managers') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="card shadow">
            <div class="card-body ">
                <div id="page-data">
                    @include('DashboardSuperAdmin.SuperAdmin.Manager.Section.indexTable',['managers' => $managers])

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
