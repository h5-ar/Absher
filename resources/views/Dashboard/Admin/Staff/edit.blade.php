@use('App\Enums\UserGender')
@use('Spatie\Permission\Models\Role')
@extends('Dashboard.Layouts.adminLayout')

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
    {{ translate('Edit Staff') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-body">
                <form method="POST" id="createUserForm" action="{{ route('dashboard.staffs.update', $user->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <x-inputs.Multi-Vertical.input value="{{ $user->name }}" label="Name" name="name"
                            placeholder="First Name" inputId="name" required isRequired="true"
                            description="Enter User Name" />
                        <x-inputs.Multi-Vertical.input value="{{ $user->last_name }}" label="last Name" name="last_name"
                            placeholder="last Name" inputId="last_name" required description="Enter User Last Name" />

                        <x-inputs.Multi-Vertical.input value="{{ $user->email }}" label="Email" name="email"
                            placeholder="Email" inputId="email" type="email" required isRequired="true"
                            description="Enter User Email" />

                        <x-inputs.Multi-Vertical.input value="{{ $user->username }}" label="Username" name="username"
                            placeholder="Username" inputId="username" required isRequired="true"
                            description="Enter Username" />

                        <x-inputs.Multi-Vertical.input value="{{ $user->phone_number }}" label="Phone Number"
                            name="phone_number" placeholder="09XXXXXXXX" inputId="phone_number"
                            onkeypress="return isNumberKey(event,10)" required isRequired="true"
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
                            <div class="mb-1">
                                <label class="col-form-label fs-5 fw-bolder isRequired"
                                    for="roles-select">{{ translate('Role') }}</label>
                                <x-SVG.alert-circle description="Select The Roles (At Least One)" />

                                <select class="select2 form-select" multiple="multiple" name="roles[]" id="roles-select">



                                </select>
                            </div>
                        </div>
                        <x-Date.picker-h value="{{ $user->birth_date }}" name="birth_date" dateId="birth_date"
                            label="Birth Date" required isRequired="true" description="Select User Birth Date" />
                        <x-inputs.Multi-Vertical.input label="Password" name="password" placeholder="Enter Password"
                            inputId="password" type="password" description="Enter User Password" />

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


            var preloadedData = [];

            @foreach ($roles as $role)
                preloadedData.push({
                    id: '{{ $role->name }}',
                    text: '{{ $role->name }}',
                    'selected': {{ (int) $user->roles->contains($role) }}
                });
            @endforeach

            $('#roles-select').select2({
                data: preloadedData,
            })
        });

        function validateInputs() {
            var form = $('#createUserForm')[0];
            var rules = {
                _token: Joi.string().required(),
                _method: Joi.string().required(),

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
                // password: Joi.string().allow(null, '').messages({
                //     '*': '{{ translate('password must be between 8 and 20 char') }}'
                // }),
                profile: Joi.allow(null),

                'roles[]': Joi.array().min(1).valid(...@json($roles->pluck('name'))).required().items(Joi.string()
                    .messages({
                        '*': "{{ translate('Role is required') }}"
                    })),

                birth_date: Joi.date().iso().required().max(new Date(new Date().setFullYear(new Date().getFullYear() -
                    18))).messages({
                    '*': "{{ translate('Birth date is required') }}"
                }),
                password: Joi.string().min(8).max(20).allow(null, '').required().messages({
                    '*': '{{ translate('password must be between 8 and 20 char') }}'
                }),
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());


            var formDataObject = Object.fromEntries(
                Object.entries(formDataObject).map(([key, value]) => [key, typeof value === 'string' ? value.trim() :
                    value
                ])
            );
            const schema = Joi.object(rules);


            const result = schema.validate(formDataObject);
            if (result.error) {
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
