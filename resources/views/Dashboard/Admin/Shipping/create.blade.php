@extends('Dashboard.Layouts.adminLayout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('title')
{{ translate('Create Shipment') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form id="createForm" class="form form-horizontal" method="POST"
                action="{{ route('store.shipping') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-inputs.h-input inputName="sender_name" inputId="sender_name" lable="Sender Name"
                                description="Enter Sender Name" placeholder="{{ translate('Sender Name') }}" />

                            <x-inputs.h-input inputName="sender_phone" inputId="sender_phone" lable="Sender Phone" placeholder=" 09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number" />

                            <x-inputs.h-input inputName="sender_national_number" inputId="sender_national_number" lable="Sender National Number" placeholder=" 0XXXXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter National Number" />

                            <x-inputs.h-input inputName="recipient_name" inputId="recipient_name" lable="Recipient Name"
                                description="Enter Recipient Name" placeholder="{{ translate('Recipient Name') }}" />

                            <x-inputs.h-input inputName="recipient_phone" inputId="recipient_phone" lable="Recipient Phone" placeholder=" 09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number" />

                            <x-inputs.h-input inputName="recipient_national_number" inputId="recipient_national_number" lable="Recipient National Number" placeholder=" 0XXXXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter National Number" />

                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit />
                                <x-Button.rest />
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</x-Content.normal>
@endsection