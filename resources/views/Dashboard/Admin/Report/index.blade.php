@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Messages') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.Report.Sections.indexTable', ['reports' => $reports])
                </div>
            </div>
        </div>

    </x-Content.normal>
@endsection


@section('modal')
    <x-Modals.delete message="Are you sure to delete this report ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
