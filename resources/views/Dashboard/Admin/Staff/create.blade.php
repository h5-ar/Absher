@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\UserGender')
@use('Spatie\Permission\Models\Role')

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

@section('title')
    {{ translate('Add Staff') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-body">

                <form method="POST" id="createUserForm" action="{{ route('dashboard.staffs.store') }}"
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
                                    <option class="form-control" value="male">
                                        {{ translate('Male User') }}</option>
                                    <option class="form-control" value="female">
                                        {{ translate('Female User') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                for="roles-select">{{ translate('Role') }}</label>
                            <x-SVG.alert-circle description="Select The Roles (At Least One)" />
                            <select class="select2 form-select" multiple="multiple" name="roles[]" id="roles-select">
                                @foreach ($roles as $role)
                                    <option class="form-control" value="{{ $role->name }}">
                                        {{ str($role->name)->replace('_', ' ') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <x-Date.picker-h name="birth_date" dateId="birth_date" label="Birth Date" required isRequired="true"
                            description="select User Birth Date" />

                        <x-inputs.Multi-Vertical.input label="Password" name="password" placeholder="Enter Password"
                            inputId="password" type="password" isRequired="true" description="Enter User Password" />

                        <x-inputs.Multi-Vertical.input label="Confirm Password" name='password_confirmation'
                            placeholder="Enter Password" inputId="confirm_password" type="password" isRequired="true"
                            description="Enter User Password Again" />
                        <x-inputs.Multi-Vertical.input label="Profile Image" name="profile" inputId="profile" type="file"
                            accept="image/*" size="col-md-6 col-12" isRequired="true" description="Upload User Profile" />

                    </div>
                    <x-Button.submit type="button" onclick="validateInputs()" />
                    <x-Button.rest />

                </form>
            </div>

        </div>
    </x-Content.normal>
@endsection


@push('layout-scripts')
    <script>
        $(document).ready(function() {
            $("#roles-select").select2();
        })

        function validateInputs() {
            console.log();
            console.log($("#roles-select").val());
            var form = $('#createUserForm')[0];
            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                last_name: Joi.string().required().messages({
                    '*': '{{ translate('Last name is required') }}',
                }),

                email: Joi.string().required(),

                username: Joi.string().required().messages({
                    '*': "{{ translate('Username is required') }}"
                }),

                phone_number: Joi.number().min(10).required().messages({
                    '*': "{{ translate('Phone number is required') }}"
                }),

                gender: Joi.string().valid('male', 'female').required().messages({
                    '*': "{{ translate('Gender is required') }}"
                }),

                'roles[]': Joi.array().min(1).valid(...@json($roles->pluck('name'))).required().items(Joi.string()
                    .messages({
                        '*': "{{ translate('Role is required') }}"
                    })),

                birth_date: Joi.date()
                    .iso()
                    .max(new Date(new Date().setFullYear(new Date().getFullYear() - 18)))
                    .required()
                    .messages({
                        'date.max': "{{ translate('Birth date must be at most 18 years ago') }}",
                        '*': "{{ translate('Birth date is required') }}",
                    }),

                password: Joi.string().min(8).max(20).required().messages({
                    '*': '{{ translate('password must be between 8 and 20 char') }}'
                }),

                password_confirmation: Joi.string().valid(Joi.ref('password')).required().messages({
                    '*': '{{ translate('password confirmation must match password') }}'
                }),
                profile: Joi.allow().messages({
                    '*': '{{ translate('profile') }}'
                })

            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());

            var formDataObject = Object.fromEntries(
                Object.entries(formDataObject).map(([key, value]) => [key, typeof value === 'string' ? value
                    .trim() :
                    value
                ])
            );
            const schema = Joi.object(rules);


            const result = schema.validate(formDataObject);
            if (result.error) {
                console.log(result.error);
                errorToast(result.error.message);
                var label = result.error.details[0].context.label;

                var targetElement = $(`[name="${label}"]`);
                if (!result.error.details[0].context.label.includes('imageId') && targetElement) {
                    $('html, body').animate({
                        scrollTop: targetElement.height(),
                        behavior: 'smooth'
                    }, 1500);

                    $('html, body').promise().done(function() {
                        targetElement.focus();
                    });
                }

            } else {
                $(form).submit();
            }
        }
    </script>
@endpush
