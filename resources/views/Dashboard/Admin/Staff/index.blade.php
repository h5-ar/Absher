@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Staffs') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">

            <div class="card-header row">
                @can(Permission::STAFF_CREATE->value)
                    <x-Button.add name="Add Staff" route="{{ route('dashboard.staffs.create') }}" />
                @endcan
            </div>
            <div class="card-body">
               <div id="page-data">
                @include('Dashboard.Admin.Staff.Sections.indexTable',['staffs'=>$staffs])
               </div>
            </div>
        </div>

    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this staff ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
