@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Buses') }}
@endsection
@section('content')
    <x-Content.normal>
        <div class="card shadow">
      
                <div class="card-header">
                    <x-Button.add name="Add Bus" route="{{ route('add.bus') }}" />
                </div>
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Bus.Section.indexTable',['buses' => $buses])
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
