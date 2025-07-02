@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Plans') }}
@endsection
@section('content')
<x-Content.normal>
    <div class="card shadow">
        <div class="card-header">
            <x-Button.add name="Add Plan" route="{{ route('add.plan') }}" />
            <div class="col-md-3 col-sm-6 col-xs-6 col-8">
                <label for="day-filter" class="col-form-label me-2">{{ translate('Plan Name') }}:</label>
                <input type="text"
                    class="form-control"
                    id="name-filter"
                    placeholder="{{ translate('Search by plan name') }}"
                    value="{{ request()->name }}">
            </div>
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
<x-Modals.delete message="Are you sure to delete this Plan ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
<script>
    $(document).ready(function() {
        $('#name-filter').keypress(function(e) {
            if (e.which == 13) {
                const name = $(this).val();
                window.location.href = "{{ route('plan.ByName', '') }}/" + name;
            }
        });
    });

    function openDeleteModal(elment) {
        $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
    }
</script>
@endpush