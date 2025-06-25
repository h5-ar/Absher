@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Shipments') }}
@endsection
@section('content')
    <x-Content.normal>
        <div class="card shadow">
      
                <div class="card-header">
                    <x-Button.add name="Add Shipment" route="{{ route('add.shipping') }}" />
                </div>
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Shipping.Section.indexTable',['shipments' => $shipments])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this Shipping ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
