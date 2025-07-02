@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\BusType')

@section('title')
{{ translate('Buses') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <x-Button.add name="Add Bus" route="{{ route('add.bus') }}" />

            <div class="col-md-2 col-sm-6 col-xs-6 col-8">
                <label for="bus-type-filter" class="col-form-label me-2">{{ translate('Bus Type') }}:</label>
                <select class="select2 form-select" name="type" id="bus-type-filter">
                    <option value="{{ route('bus.index') }}" @selected(!request()->has('type'))>
                        {{ translate('All') }}
                    </option>
                    @foreach (BusType::cases() as $type)
                    <option value="{{ route('bus.indexByType', $type->value) }}"
                        @selected(request()->route('type') == $type->value)>
                        {{ translate($type->value) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-body">
            <div id="page-data">
                @include('Dashboard.Admin.Bus.Section.indexTable', ['buses' => $buses])
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection

@section('modal')
<x-Modals.delete message="Are you sure to delete this Bus?" title="Delete Bus"></x-Modals.delete>
@endsection

@push('layout-scripts')
<script>
    $(document).ready(function() {
        $('#bus-type-filter').on('change', function() {
            window.location.href = $(this).val();
        });
    });

    function openDeleteModal(element) {
        $("#deleteFormModal").attr("action", $(element).attr('deleteUrl'));
    }
</script>
@endpush