@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Add Company') }}
@endsection



@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-pickadate.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush


@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add Company') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('store.company') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="name" inputId="name" lable="Company Name"
                                description="Enter Company Name" placeholder="{{ translate('Company Name') }}"
                                   />

                            <x-inputs.h-input inputName="phone" inputId="phone" lable="Phone Number"
                                description="Enter Company Name" placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number"    />
                            <x-inputs.h-input inputName="email" inputId="email" lable="Company Email"
                                description="Enter Company Email" placeholder="{{ translate('Company Email') }}"
                                type="email"    />

                            <x-inputs.h-input inputName="username" inputId="username" lable="Username"
                                description="Enter Username" placeholder="{{ translate('Username') }}"
                                   />
                            <x-inputs.h-input inputName="password" inputId="password" lable="Password"
                                description="Enter Password" placeholder="{{ translate('Password') }}"
                                type="password"    />
                            <x-inputs.h-input inputName="password_confirmation" inputId="password_confirmation" lable="Confirm Password"
                                description="Enter User Password Again" placeholder="{{ translate('Company Password') }}"
                                type="password"    />

                            <x-inputs.Multi-Vertical.textarea name="description" id="description" label="Description"
                                placeholder="{{ translate('Description') }}"
                                   />

                            <x-inputs.h-manager-select description="Select Manager" />

                        </div>
                </div>
                <div class="col-sm-9 offset-sm-3">
                    <x-Button.submit />
                    <x-Button.rest />
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-Content.normal>
@endsection