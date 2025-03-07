@use('App\Enums\CompanySize')
@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Seller') }}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/form-wizard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/authentication.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-pickadate.css') }}">
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-wizard.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('content')
    <x-Content.normal>
        <div class="content-body">

            <x-Wizard.horizontal.container>
                <x-Wizard.horizontal.header-container>

                    <x-Wizard.horizontal.step-header target="user-info" title="Personal Information"
                        subTitle="User Personal Information" feather="user" />

                    <x-Wizard.horizontal.step-header target="seller-info" title="Business Information"
                        subTitle="Seller Business Information" next="false" feather="dollar-sign" />

                </x-Wizard.horizontal.header-container>

                <x-Wizard.horizontal.content-container>
                    <form method="POST" id="createSellerForm" action="{{ route('dashboard.sellers.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <x-Wizard.horizontal.step-content target="user-info" feather="" title="Personal Information"
                            subTitle="User Personal Information" first='true'>
                            <div class="row">
                                <x-inputs.Multi-Vertical.input label="Name" name="name" placeholder="First Name"
                                    inputId="name" required isRequired="true" description="Enter User Name" />
                                <x-inputs.Multi-Vertical.input label="last Name" name="last_name" placeholder="last Name"
                                    inputId="last_name" description="Enter User Last Name" />

                                <x-inputs.Multi-Vertical.input label="Email" name="email" placeholder="Email"
                                    inputId="email" type="email" description="Enter User Email" />

                                <x-inputs.Multi-Vertical.input label="Username" name="username" placeholder="Username"
                                    inputId="username" required isRequired="true" description="Enter Username" />

                                <x-inputs.Multi-Vertical.input label="Phone Number" name="phone_number"
                                    placeholder="09XXXXXXXX" inputId="phone_number"
                                    onkeypress="return isNumberKey(event,10)" required isRequired="true"
                                    description="Enter Phone Number" />

                                <x-inputs.Multi-Vertical.select selectId="gender" lable="Gender" name="gender"
                                    isRequired="true" description="Select User Gender" title="Gender" required>
                                    <x-inputs.option value="male" lable="Man" />
                                    <x-inputs.option value="female" lable="Woman" />
                                </x-inputs.Multi-Vertical.select>

                                <x-inputs.Multi-Vertical.input label="Join Code" name="join_code" placeholder="Join Code"
                                    inputId="join_code" description="Enter Join Code" />

                                <x-Date.picker-h name="birth_date" dateId="birth_date" label="Birth Date"
                                    description="select User Birth Date" />

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="col-form-label fs-5 fw-bolder  isRequired "
                                            for="login-password">{{ translate('Password') }}</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input
                                                class="form-control form-control-merge @error('password') is-invalid @enderror"
                                                id="login-password" type="password" value="{{ old('password') }}"
                                                name="password" placeholder="············"
                                                aria-describedby="login-password" tabindex="2" required /><span
                                                class="input-group-text cursor-pointer"><i data-feather="eye"
                                                    @error('password') style="color: rgb(234, 84, 85)" @enderror></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="col-form-label fs-5 fw-bolder  isRequired "
                                            for="password_confirmation">{{ translate('Confirm Password') }}</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input
                                                class="form-control form-control-merge @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" type="password" value="{{ old('password_confirmation') }}"
                                                name="password_confirmation" placeholder="············"
                                                aria-describedby="login-password" tabindex="2" required /><span
                                                class="input-group-text cursor-pointer"><i data-feather="eye"
                                                    @error('password') style="color: rgb(234, 84, 85)" @enderror></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </x-Wizard.horizontal.step-content>

                        <x-Wizard.horizontal.step-content target="seller-info" feather=""
                            title="Business Information" subTitle="Seller Business Information" last="true">
                            <div class="row">
                                <x-inputs.Multi-Vertical.input label="Company Name" name="company_name"
                                    placeholder="Company Name" inputId="company_name" description="Enter Company Name" />

                                <x-inputs.Multi-Vertical.select selectId="company_size" lable="Company Size"
                                    description="Select Company Size" name="company_size" title="Company Size">
                                    @foreach (CompanySize::cases() as $size)
                                        <x-inputs.option value="{{ $size->value }}"
                                            lable="{{ str($size->name)->replace('_', ' ') }}" />
                                    @endforeach
                                </x-inputs.Multi-Vertical.select>

                                <x-inputs.Multi-Vertical.input label="Address" name="address" placeholder="Address"
                                    description="Enter Seller Address" inputId="address" required />

                                <x-inputs.Multi-Vertical.input label="City" name="city" placeholder="City"
                                    inputId="city" description="Enter City Address" />

                                <x-inputs.Multi-Vertical.input label="Street" name="street" placeholder="Street"
                                    inputId="street" description="Enter Street Address" />

                                <x-inputs.Multi-Vertical.input label="Industry" name="industry" placeholder="Industry"
                                    inputId="industry" description="Enter Seller Industry" />

                                <x-inputs.Multi-Vertical.textarea label="Description" id="description"
                                    name="description" />

                                <x-inputs.Multi-Vertical.textarea label="Additional Comments" id="comments"
                                    name="comments" />

                                <x-inputs.Multi-Vertical.select selectId="preference" lable="Preference"
                                    description="Select Contact Preference" name="preference" title="Preference Type"
                                    required>
                                    <x-inputs.option value="email" lable="Email" />
                                    <x-inputs.option value="phone_number" lable="Phone Number" />
                                </x-inputs.Multi-Vertical.select>

                                <div class="col-md-6 col-12 mt-1">
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-around">
                                            <div>
                                                <x-inputs.switch name="active" id="active" label="Active"
                                                    value="false" description="Activate Seller" />
                                            </div>
                                            <div>
                                                <x-inputs.switch name="cash" id="cash" label="Cash Pay"
                                                    value="false" description="Seller Accept Cash" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <x-inputs.Multi-Vertical.input label="Bank Name" name="bank_name" placeholder="Bank Name"
                                    inputId="bank_name" description="Enter Bank Name" />

                                <x-inputs.Multi-Vertical.input label="Account Number" name="account_number"
                                    placeholder="Account Number" inputId="account_number"
                                    onkeypress="return isNumberKey(event,15)" description="Enter Bank Account Number" />

                                <x-inputs.Multi-Vertical.input label="Portfolio File" name="portfolio"
                                    inputId="portfolio" type="file" size="col-md-4 col-12"
                                    description="Upload Portfolio File" />

                                <x-inputs.Multi-Vertical.input label="Supporting Document" name="supporting_document"
                                    inputId="supporting_document" type="file" size="col-md-4 col-12"
                                    description="Upload Supporting Document File" />

                                <x-inputs.Multi-Vertical.input label="Marketing Plan" name="marketing_plan"
                                    inputId="Marketing Plan" type="file" size="col-md-4 col-12"
                                    description="Upload Markiting Plan File" />

                                <x-Maps.google label="Select Seller Location"
                                    description="Select Seller Location On Map" />

                            </div>
                        </x-Wizard.horizontal.step-content>
                    </form>
                </x-Wizard.horizontal.content-container>
            </x-Wizard.horizontal.container>
        </div>
    </x-Content.normal>
@endsection


@push('layout-scripts')
    <script>
        function validateInputs() {
            var form = $('#createSellerForm')[0];
            // Define the custom validation function
            const accountNumberWhenBankNameExists = (value, helpers) => {
                // If bankName exists, accountNumber must also exist
                console.log(helpers.state.ancestors[0].bank_name);
                console.log(value);
                if (helpers.state.ancestors[0].bank_name !== undefined && value === undefined && value !== '') {
                    return helpers.error('any.required');
                }
                return value;
            };
            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                last_name: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Last name is required') }}',
                }),

                email: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Email is required') }}',
                }),

                username: Joi.string().required().messages({
                    '*': '{{ translate('Username is required') }}',
                }),

                phone_number: Joi.string().regex(/^09/).min(10).max(10).required().messages({
                    '*': "{{ translate('Phone number must be a vaild phone number') }}"
                }),

                gender: Joi.string().valid('male', 'female').required().messages({
                    '*': "{{ translate('Seller Gender is required') }}"
                }),

                join_code: Joi.string().allow('', null),

                birth_date: Joi.date().allow(null, '').required().messages({
                    '*': "{{ translate('Birth date is required') }}"
                }),

                password: Joi.string().required().min(8).max(20).messages({
                    '*': '{{ translate('password is required') }}',
                }),

                password_confirmation: Joi.string().required().valid(Joi.ref('password')).messages({
                    '*': '{{ translate('Confirm Password is required') }}',
                }),

                company_name: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Company name is required') }}',
                }),

                address: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('address is required') }}',
                }),

                city: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('City is required') }}',
                }),

                street: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Street is required') }}',
                }),

                industry: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Work specialty is required') }}',
                }),

                description: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Description is required') }}',
                }),

                comments: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('comments is required') }}',
                }),

                preference: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Preference is required') }}',
                }),
                company_size: Joi.string().allow(null, '').required(),


                bank_name: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Bank Name is required') }}',
                }),

                account_number: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Account Number is required') }}',
                }),

                portfolio: Joi.allow(null, '').required().messages({
                    '*': '{{ translate('portfolio is required') }}',
                }),

                supporting_document: Joi.allow(null, '').required().messages({
                    '*': '{{ translate('supporting_document is required') }}',
                }),

                marketing_plan: Joi.allow(null, '').required().messages({
                    '*': '{{ translate('marketing_plan is required') }}',
                }),

                long: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Location is required') }}',
                }),

                lat: Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Location is required') }}',
                }),
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());

            var formDataObject = Object.fromEntries(
                Object.entries(formDataObject).map(([key, value]) => [key, typeof value === 'string' ? value.trim() :
                    value
                ])
            );

            if (formDataObject.hasOwnProperty('active')) {
                rules['active'] = Joi.string().allow(null, '').messages({
                    '*': '{{ translate('active is required') }}',
                });
            }

            if (formDataObject.hasOwnProperty('cash')) {
                rules['cash'] = Joi.string().allow(null, '').messages({
                    '*': '{{ translate('cash is required') }}',
                });
            }

            if (formDataObject['bank_name']) {
                rules['account_number'] = Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('Account Number is required') }}',
                });
            }

            if (formDataObject['account_number'] || !formDataObject.hasOwnProperty('cash')) {
                rules['bank_name'] = Joi.string().allow(null, '').required().messages({
                    '*': '{{ translate('bank name is required') }}',
                });
            }

            const schema = Joi.object(rules);


            const result = schema.validate(formDataObject);

            if (result.error) {
                errorToast(result.error.message);
                var label = result.error.details[0].context.label;
            } else {
                $(form).submit();
            }
        }
    </script>
@endpush
