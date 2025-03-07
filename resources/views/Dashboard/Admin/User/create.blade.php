@use('App\Enums\UserGender')
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
    {{ translate('Add User') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-body">

                <form method="POST" id="createUserForm" action="{{ route('dashboard.users.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <x-inputs.Multi-Vertical.input label="Name" name="name" placeholder="First Name" inputId="name"
                            required isRequired="true" description="Enter User Name" />
                        <x-inputs.Multi-Vertical.input label="last Name" name="last_name" placeholder="last Name"
                            inputId="last_name" required description="Enter User Last Name" />

                        <x-inputs.Multi-Vertical.input label="Email" name="email" placeholder="Email" inputId="email"
                            type="email" required isRequired="true" description="Enter User Email" />

                        <x-inputs.Multi-Vertical.input label="Username" name="username" placeholder="Username"
                            inputId="username" required isRequired="true" description="Enter Username" />

                        <x-inputs.Multi-Vertical.input label="Phone Number" name="phone_number" placeholder="09XXXXXXXX"
                            inputId="phone_number" onkeypress="return isNumberKey(event,10)" required isRequired="true"
                            description="Enter Phone Number" />

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="col-form-label fs-5 fw-bolder isRequired"
                                    for="gender">{{ translate('Gender') }}</label>
                                <x-SVG.alert-circle description="Select User Gender" />
                                <select class="select2 form-select" name="gender" id="default-select">
                                    @foreach (UserGender::cases() as $gender)
                                        <option class="form-control" value="{{ strtolower($gender->name) }}">
                                            {{ translate("$gender->name User") }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <x-inputs.Multi-Vertical.input label="Join Code" name="join_code" placeholder="Join Code"
                            inputId="join_code" description="Enter Join Code" />

                        <x-Date.picker-h name="birth_date" dateId="birth_date" label="Birth Date" required isRequired="true"
                            description="select User Birth Date" />

                        <x-inputs.Multi-Vertical.input label="Password" name="password" placeholder="Enter Password"
                            inputId="password" type="password" isRequired="true" description="Enter User Password" />

                        <x-inputs.Multi-Vertical.input label="Confirm Password" name='password_confirmation'
                            placeholder="Enter Password" inputId="confirm_password" type="password" isRequired="true"
                            description="Enter User Password" isRequired="true" description="Enter User Password Again" />

                        <x-inputs.Multi-Vertical.input label="Profile Image" name="profile" inputId="profile" type="file"
                            accept="image/*" size="col-md-6 col-12" isRequired="true" description="Upload User Profile" />
                    </div>

                    <x-Button.submit />
                    <x-Button.rest />

                </form>
            </div>

        </div>
    </x-Content.normal>
@endsection
