@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Companies') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">
        <div class="card-body ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="col-md-3 col-sm-6 col-xs-6 col-8">
                    <label for="day-filter" class="col-form-label me-2">{{ translate('Company Name') }}:</label>
                    <input type="text"
                        class="form-control"
                        id="name-filter"
                        placeholder="{{ translate('Search by company name') }}"
                        value="{{ request()->name }}">
                </div>
            </div>
            <div id="page-data">
                @include('DashboardSuperAdmin.SuperAdmin.Company.Section.indexTable',['companies' => $companies])

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
                window.location.href = "{{ route('company.ByName', '') }}/" + name;
            }
        });
    });

    function openDeleteModal(elment) {
        $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
    }
</script>
@endpush