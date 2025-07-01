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
{{ translate('Edit User') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Edit User') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="createUserForm" action="{{ route('update.user', $user->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <x-inputs.h-input inputName="first_name" inputId="first_name" lable="First Name" placeholder="First Name"
                                description="Enter First Name" value="{{ $user->first_name }}" isRequired='true' />
                            <x-inputs.h-input inputName="last_name" inputId="last_name" lable="Last Name" placeholder="Last Name"
                                description="Enter last Name" value="{{ $user->last_name }}" isRequired='true' />
                            <x-inputs.h-input inputName="phone" inputId="phone" lable="Phone Number"
                                placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number" value="{{ $user->phone }}" isRequired="true" />
                            <x-inputs.h-input inputName="email" inputId="email" lable="User Email"
                                description="Enter User Email" placeholder="{{ translate('User Email') }}"
                                type="email" value="{{ $user->email }}" />

                            <x-inputs.h-input inputName="username" inputId="username" lable="Username"
                                description="Enter Username" placeholder="{{ translate('Username') }}"
                                value="{{ $user->username }}" />
                            <x-inputs.h-input inputName="password" inputId="password" lable="Password"
                                description="Enter Password" placeholder="{{ translate('Password') }}"
                                type="password" value="{{ $user->password }}" isRequired="true" />
                            <x-inputs.h-input inputName="password_confirmation" inputId="password_confirmation" lable="Confirm Password"
                                description="Enter User Password Again" placeholder="{{ translate('User Password') }}"
                                type="password" value="{{ $user->password }}" isRequired="true" />

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-2 col-sm-3"> <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="gender">{{ translate('Statut User') }}</label>
                                            <x-SVG.alert-circle description="Select Statut User" />
                                        </div>
                                        <div class="col-10 col-sm-9">

                                            <select class="select2 form-select" name="statut_user" id="default-select">
                                                <option value="Locked" {{ old('statut_user', $user->statut_user ?? 'Unlocked') == 'Locked' ? 'selected' : '' }}>Locked</option>
                                                <option value="Unlocked" {{ old('statut_user', $user->statut_user ?? 'Unlocked') == 'Unlocked' ? 'selected' : '' }}>Unlocked</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit />
                                <x-Button.rest />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection