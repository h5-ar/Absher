@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Buses') }}
@endsection
@section('content')
<x-Content.normal>
    <div class="card shadow">

        <div class="card-header">
            <x-Button.add name="Add Bus" route="{{ route('SAadd.bus') }}" />
            <div class="col-md-3 col-sm-6 col-xs-6 col-8">
                <label for="day-filter" class="col-form-label me-2">{{ translate('Company Name') }}:</label>
                <input type="text"
                    class="form-control"
                    id="name-filter"
                    placeholder="{{ translate('Search bus for company name') }}"
                    value="{{ request()->name }}">

            </div>
        </div>
        <div class="card-body ">
            <div id="page-data">
                @include('DashboardSuperAdmin.SuperAdmin.Bus.Section.indexTable',['buses' => $buses])
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
     $(document).ready(function() {
        $('#name-filter').keypress(function(e) {
            if (e.which == 13) {
                const name = $(this).val();
                window.location.href = "{{ route('bus.company.ByName', '') }}/" + name;
            }
        });
    });
    function openDeleteModal(elment) {
        $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
    }
</script>
@endpush