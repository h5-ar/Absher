@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Edit Passenger') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form id="editForm" class="form form-horizontal" method="POST" action="{{ route('SApassenger.update', $passenger->id) }}">
                @csrf
                @method('PUT')
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="passenger_id" value="{{ $passenger->id }}">
                                <input type="hidden" name="reservation_id" value="{{ $passenger->reservation_id }}">

                                <x-inputs.h-input
                                    inputName="first_name"
                                    inputId="first_name"
                                    lable="{{ translate('First Name') }}"
                                    type="text"
                                    value="{{ $passenger->first_name }}" />

                                <x-inputs.h-input
                                    inputName="father_name"
                                    inputId="father_name"
                                    lable="{{ translate('Father Name') }}"
                                    type="text"
                                    value="{{ $passenger->father_name }}" />
                                <x-inputs.h-input
                                    inputName="National_number"
                                    inputId="National_number"
                                    lable="{{ translate('National Number') }}"
                                    type="text"
                                    value="{{ $passenger->National_number }}" 
                                     onkeypress="return isNumberKey(event,10)"/>
                                <x-inputs.h-input
                                    inputName=" last_name"
                                    inputId="last_name"
                                    lable="{{ translate('Last Name') }}"
                                    type="text"
                                    value="{{ $passenger->last_name }}" />

                                <x-inputs.h-input
                                    inputName="seat_number"
                                    inputId="seat_number"
                                    lable="{{ translate('Seat Number') }}"
                                    type="number"
                                    value="{{ $passenger->seat_number }}" />
                                <input type="hidden" name="passenger_id" value="{{ $passenger->id }}">

                                <!-- Departure Point -->
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder">{{ translate('Departure Point') }}</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="select2 form-select rounded" name=" departure_point">
                                                <option value="{{ $passenger->from }}" selected>{{ $passenger->from }}</option>
                                                @foreach($stations as $station)
                                                @if(!empty($station) && $station != $passenger->from)
                                                <option value="{{ $station }}">{{ $station }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arrival Point -->
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder">{{ translate('Arrival Point') }}</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="select2 form-select rounded" name="arrival_point">
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
                </div>
                <div class="col-sm-9 offset-sm-3">
                    <x-Button.submit />
                    <x-Button.rest />
                </div>
            </form>
        </div>
    </div>
</x-Content.normal>
@endsection