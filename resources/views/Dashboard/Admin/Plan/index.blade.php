@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Plans') }}
@endsection
@section('content')
    <x-Content.normal>
        <div class="card shadow">
                <div class="card-header">
                    <x-Button.add name="Add Plan" route="{{ route('add.plan') }}" />
                </div>
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Plan.Section.indexTable',['plans' => $plans])
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
