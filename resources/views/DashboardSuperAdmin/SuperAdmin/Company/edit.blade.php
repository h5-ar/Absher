@extends('DashboardSuperAdmin.Layouts.adminLayout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('title')
{{ translate('Edit Cpmpany') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="createUserForm" action="{{ route('update.company', $company->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">

                    <x-inputs.h-input inputName="name" inputId="name" lable="Company Name"
                        description="Enter Company Name" placeholder="{{ translate('Company Name') }}"
                        value="{{ $company->name }}" />

                    <x-inputs.h-input inputName="phone" inputId="phone" lable="Phone Number"
                        description="Enter Company Name" placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                        description="Enter Phone Number" value="{{ $company->phone }}" />
                    <x-inputs.h-input inputName="email" inputId="email" lable="Company Email"
                        description="Enter Company Email" placeholder="{{ translate('Company Email') }}"
                        type="email" value="{{ $company->email }}" />

                    <x-inputs.h-input inputName="username" inputId="username" lable="Username"
                        description="Enter Username" placeholder="{{ translate('Username') }}"
                        value="{{ $company->username }}" />
                    <x-inputs.h-input inputName="password" inputId="password" lable="Password"
                        description="Enter Password" placeholder="{{ translate('Password') }}"
                        type="password" value="{{ $company->password }}" isRequired="true" />
                    <x-inputs.h-input inputName="password_confirmation" inputId="password_confirmation" lable="Confirm Password"
                        description="Enter User Password Again" placeholder="{{ translate('User Password') }}"
                        type="password" value="{{ $company->password }}" isRequired="true" />
                    <x-inputs.Multi-Vertical.textarea name="description" id="description" label="Description"
                        placeholder="{{ translate('Description') }}"
                        value="{{ $company->Description }}" />

                    <x-inputs.h-manager-select typeValue="{{ $company->manager_id }}" description="Select Manager" />
                </div>


                <x-Button.submit />
                <x-Button.rest />



            </form>
        </div>
    </div>
</x-Content.normal>
@endsection