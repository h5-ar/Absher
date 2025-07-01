@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Days')
@use('App\Enums\Governorates')

@section('title')
{{ translate('Trips') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="col-md-3 col-sm-6 col-xs-6 col-8">
                    <label for="day-filter" class="col-form-label me-2">{{ translate('Day Trip') }}:</label>
                    <select class="select2 form-select" name="day" id="day-filter">
                        <option value="{{ route('trip.index') }}" @selected(!request()->has('day'))>
                            {{ translate('All') }}
                        </option>
                        @foreach (Days::cases() as $day)
                        <option value="{{ route('trip.filter', ['day' => $day->value]) }}"
                            @selected(request()->input('day') == $day->value)>
                            {{ translate($day->value) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-8">
                    <label for="governorate-filter" class="col-form-label me-2">{{ translate('Governorate Trip') }}:</label>
                    <select class="select2 form-select" name="governorate" id="governorate-filter">
                        <option value="{{ route('trip.index') }}" @selected(!request()->has('governorate'))>
                            {{ translate('All') }}
                        </option>
                        @foreach (Governorates::cases() as $governorate)
                        <option value="{{ route('trip.filter', ['governorate' => $governorate->value]) }}"
                            @selected(request()->input('governorate') == $governorate->value)>
                            {{ translate($governorate->value) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="page-data">
                @include('Dashboard.Admin.Trip.Section.indexTable',['trips' => $trips])
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection

@section('modal')
<x-Modals.delete message="Are you sure to delete this trip?"></x-Modals.delete>
@endsection

@push('layout-scripts')
<script>
    $(document).ready(function() {
        $('#governorate-filter, #day-filter').on('change', function() {
            window.location.href = $(this).val();
        });
    });

    function openDeleteModal(element) {
        $("#deleteFormModal").attr("action", $(element).attr('data-delete-url'));
    }
</script>
@endpush