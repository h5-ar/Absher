@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Reservations') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">

        <div class="card-header">
            <x-Button.add name="Add Reservation" route="{{ route('add.reservation') }}" />
        </div>

        <div class="card-body ">
            <div id="page-data">
                @include('Dashboard.Admin.Reservation.Section.indexTable',['reservations' => $reservations])
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection


@section('modal')
    <x-Modals.delete message="Are you sure to delete this Reservation ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush