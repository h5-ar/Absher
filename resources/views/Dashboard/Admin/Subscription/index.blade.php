@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Subscription') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">

        <div class="card-body ">
            <div id="page-data">
                @include('Dashboard.Admin.Subscription.Section.indexTable',['subscriptions' => $subscriptions])

            </div>
        </div>
    </div>
</x-Content.normal>
@endsection

@section('modal')
<x-Modals.delete message="Are you sure to delete this Subscription ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
<script>
    function openDeleteModal(elment) {
        $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
    }
</script>
@endpush