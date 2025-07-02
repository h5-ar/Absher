@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Notification') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">
        <div class="card-body ">
            <div id="page-data">
                @include('DashboardSuperAdmin.SuperAdmin.Notification.Section.indexTable',['notifications' => $notifications])
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection

@section('modal')
<x-Modals.delete message="Are you sure to delete this notification ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
<script>
    function openDeleteModal(elment) {
        $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
    }
</script>
@endpush