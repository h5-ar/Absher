@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Edit Reservation') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form id="editForm" class="form form-horizontal" method="POST" action="{{ route('reservation.update', $reservation->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="trip_id" value="{{ $reservation->trip_id }}">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder">{{ translate('Trip ID') }}</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" id="trip_select" class="form-control trip-input" readonly
                                        value="{{ $reservation->trip_id }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder" for="additional_seats">{{ translate('Additional Passengers') }}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="additionalSeats" class="form-control"
                                    name="additional_seats" min="0" max="{{ 30 - $reservation->count_seats }}"
                                    placeholder="{{ translate('Enter number of additional passengers') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder" for="seats_count">{{ translate('Count Of Passengers') }}</label>
                            </div>
                            <div class="col-sm-9">
                                <input value="{{ $reservation->count_seats }}" type="number" id="seatsCount" class="form-control"
                                    name="seats_count" min="1" max="30"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="passengersContainer">
                    @foreach($reservation->passengers as $index => $passenger)
                    @php
                    $passengerNumber = $index + 1;
                    @endphp
                    <div class="card mb-3">
                        <div class="card-header">{{ translate('Passenger') }} {{ $passengerNumber }}</div>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <x-inputs.h-input
                                        inputName="passengers[{{ $passengerNumber }}][first_name]"
                                        inputId="passenger_{{ $passengerNumber }}_first_name"
                                        lable="{{ translate('First Name') }}"
                                        type="text"
                                        value="{{ $passenger->first_name }}" />

                                    <x-inputs.h-input
                                        inputName="passengers[{{ $passengerNumber }}][father_name]"
                                        inputId="passenger_{{ $passengerNumber }}_father_name"
                                        lable="{{ translate('Father Name') }}"
                                        type="text"
                                        value="{{ $passenger->father_name }}" />

                                    <x-inputs.h-input
                                        inputName="passengers[{{ $passengerNumber }}][last_name]"
                                        inputId="passenger_{{ $passengerNumber }}_last_name"
                                        lable="{{ translate('Last Name') }}"
                                        type="text"
                                        value="{{ $passenger->last_name }}" />

                                    <x-inputs.h-input
                                        inputName="passengers[{{ $passengerNumber }}][seat_number]"
                                        inputId="passenger_{{ $passengerNumber }}_seat_number"
                                        lable="{{ translate('Seat Number') }}"
                                        type="number"
                                        value="{{ $passenger->seat_number }}" />
                                        <input type="hidden" name="passengers[{{ $passengerNumber }}][id]" value="{{ $passenger->id }}">


                
                                    <!-- نقطة المغادرة -->
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label fs-5 fw-bolder">Departure Point</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select rounded" name="passengers[1][departure_point]">
                                                    <option value="Damascus" selected>Damascus</option>
                                                    @foreach($stations as $station)
                                                    @if(!empty($station) && $station != $passenger->from)
                                                    <option value="{{ $station }}">{{ $station }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- نقطة الوصول -->
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label fs-5 fw-bolder">Arrival Point</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select rounded" name="passengers[1][arrival_point]">
                                                    @foreach($stations as $station)
                                                    @if(!empty($station) && $station != $passenger->from)
                                                    <option value="{{ $station }}" {{ $station == $passenger->to ? 'selected' : '' }}>
                                                        {{ $station }}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- New passengers fields -->
                    <div id="newPassengersContainer"></div>

                    <div class="col-sm-9 offset-sm-3">
                        <x-Button.submit />
                        <x-Button.rest />
                    </div>
            </form>
        </div>
    </div>
</x-Content.normal>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#additionalSeats').on('input', function() {
            const additional = parseInt($(this).val()) || 0;
            const current = parseInt('{{ $reservation->count_seats }}');
            const totalSeats = current + additional;

            $('#seatsCount').val(totalSeats);
            displayNewPassengersFields(additional);
        });

        function displayNewPassengersFields(additionalSeats) {
            const container = $('#newPassengersContainer');
            container.empty();

            if (additionalSeats < 1) return;

            const startIndex = $('#passengersContainer .card').length + 1;

            for (let i = startIndex; i < startIndex + additionalSeats; i++) {
                container.append(generateNewPassengerFields(i));
                container.find('.select2').select2();
            }
        }

        function generateNewPassengerFields(passengerNumber) {
            return `
            <div class="card mb-3">
                <div class="card-header">{{ translate('Passenger') }} ${passengerNumber}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-inputs.h-input
                                inputName="passengers[${passengerNumber}][first_name]"
                                inputId="passenger_${passengerNumber}_first_name"
                                lable="{{ translate('First Name') }}"
                                type="text"
                                   />
                                
                            <x-inputs.h-input
                                inputName="passengers[${passengerNumber}][father_name]"
                                inputId="passenger_${passengerNumber}_father_name"
                                lable="{{ translate('Father Name') }}"
                                type="text"
                                   />
                                
                            <x-inputs.h-input
                                inputName="passengers[${passengerNumber}][last_name]"
                                inputId="passenger_${passengerNumber}_last_name"
                                lable="{{ translate('Last Name') }}"
                                type="text"
                                   />
                                
                            <x-inputs.h-input
                                inputName="passengers[${passengerNumber}][seat_number]"
                                inputId="passenger_${passengerNumber}_seat_number"
                                lable="{{ translate('Seat Number') }}"
                                type="number"
                                   />
                                
                            <x-inputs.h-input
                                inputName="passengers[${passengerNumber}][subscribtion_id]"
                                inputId="passenger_${passengerNumber}_subscribtion_id"
                                lable="{{ translate('Subscription Number') }}"
                                type="number" />
                                <!-- نقطة المغادرة -->
<div class="col-12">
    <div class="mb-1 row">
        <div class="col-sm-3">
            <label class="col-form-label fs-5 fw-bolder">Departure Point</label>
        </div>
        <div class="col-sm-9">
            <select class="select2 form-select rounded" name="passengers[1][departure_point]">
                <option value="Damascus" selected>Damascus</option>
                @foreach($stations as $station)
                    @if(!empty($station) && $station != $passenger->from)
                        <option value="{{ $station }}">{{ $station }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- نقطة الوصول -->
<div class="col-12">
    <div class="mb-1 row">
        <div class="col-sm-3">
            <label class="col-form-label fs-5 fw-bolder">Arrival Point</label>
        </div>
        <div class="col-sm-9">
            <select class="select2 form-select rounded" name="passengers[1][arrival_point]">
                @foreach($stations as $station)
                    @if(!empty($station) && $station != $passenger->from)
                        <option value="{{ $station }}" {{ $station == $passenger->to ? 'selected' : '' }}>
                            {{ $station }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>س
                        </div>
                    </div>
                </div>
            </div>`;
        }
    });
</script>
@endpush