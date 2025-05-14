@use('App\Enums\CompanySize')
@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Sellers') }}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/form-wizard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
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
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <x-inputs.Multi-Vertical.input value="{{ $user?->name }}" label="Name" name="name" disabled
                        placeholder="First Name" inputId="name" required />
                    <x-inputs.Multi-Vertical.input value="{{ $user?->last_name }}" label="last Name" name="last_name"
                        disabled placeholder="last Name" inputId="last_name" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->email }}" label="Email" name="email" disabled
                        placeholder="Email" inputId="email" type="email" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->username }}" label="Username" name="username" disabled
                        placeholder="Username" inputId="username" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->phone_number }}" label="Phone Number" disabled
                        name="phone_number" placeholder="09XXXXXXXX" inputId="phone_number"
                        onkeypress="return isNumberKey(event,10)" required />

                    <div class="col-md-6 col-12" id="row_gender">
                        <div class="mb-1">
                            <label class="form-label fs-5 fw-bolder" for="gender">{{ translate('Gender') }}</label>
                            <select data-placeholder="{{ translate('Gender') }}" disabled
                                class="select2 form-select border border-2 rounded" name="gender" id="gender"
                                autocomplete="off">
                                <option id="Default_gender" selected></option>
                                <option class="form-control border border-2 rounded" value="female"
                                    @selected($user?->gender?->value == 2)>
                                    {{ translate('Woman') }}
                                </option>

                                <option class="form-control border border-2 rounded" value="male"
                                    @selected($user?->gender?->value == 1)>
                                    {{ translate('Man') }}
                                </option>

                            </select>
                        </div>
                    </div>


                    <x-inputs.Multi-Vertical.input value="{{ $user?->join_code }}" label="Join Code" name="join_code"
                        placeholder="Join Code" inputId="join_code" disabled />

                    <x-Date.picker-h name="birth_date" value="{{ $user?->birth_date }}" dateId="birth_date"
                        label="Birth Date" disabled />
                </div>
                <div class="row">
                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->company_name }}" label="Company Name"
                        name="company_name" placeholder="Company Name" inputId="company_name" disabled />

                    <div class="col-md-6 col-12" id="row_company_size">
                        <div class="mb-1">
                            <label class="form-label fs-5 fw-bolder"
                                for="company_size">{{ translate('Company Size') }}</label>
                            <select data-placeholder="{{ translate('Company Size') }}" disabled
                                class="select2 form-select border border-2 rounded" name="company_size" id="company_size"
                                autocomplete="off">
                                <option id="Default_company_size" selected></option>
                                @foreach (CompanySize::cases() as $size)
                                    <option class="form-control border border-2 rounded" value="{{ $size?->value }}"
                                        @selected($user?->seller?->company_size == $size?->value)>
                                        {{ translate(str($size?->name)->replace('_', ' ')) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->address }}" label="Address" name="address"
                        disabled placeholder="Address" inputId="address" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->city }}" label="City" name="city"
                        disabled placeholder="City" inputId="city" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->street }}" label="Street" name="street"
                        disabled placeholder="Street" inputId="street" required />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->industry }}" label="Industry" disabled
                        name="industry" placeholder="Industry" inputId="industry" required />

                    <x-inputs.Multi-Vertical.textarea label="Description" id="description" name="description" disabled
                        required>{{ $user?->seller?->description }}</x-inputs.Multi-Vertical.textarea>

                    <x-inputs.Multi-Vertical.textarea label="Additional Comments" id="comments" disabled
                        name="comments">{{ $user?->seller?->comments }}</x-inputs.Multi-Vertical.textarea>

                    <div class="col-md-6 col-12" id="row_preference">
                        <div class="mb-1">
                            <label class="form-label fs-5 fw-bolder"
                                for="preference">{{ translate('Preference') }}</label>
                            <select data-placeholder="{{ translate('Preference') }}" disabled
                                class="select2 form-select border border-2 rounded" name="preference" id="preference"
                                autocomplete="off">
                                <option id="Default_preference" selected></option>
                                <option class="form-control border border-2 rounded" value="email"
                                    @selected($user?->seller?->preference == 'email')>
                                    {{ translate('Email') }}
                                </option>

                                <option class="form-control border border-2 rounded" value="phone_number"
                                    @selected($user?->seller?->preference == 'phone_number')>
                                    {{ translate('Phone number') }}
                                </option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6 col-12 mt-1">
                        <div class="mb-1">
                            <div class="d-flex justify-content-around">
                                <div>
                                    <label class="form-check-label mb-50"
                                        for="active">{{ translate('Active') }}</label>
                                    <div class="form-check form-check-primary form-switch">
                                        <input type="checkbox" name="active" @checked($user?->seller?->active) disabled
                                            class="form-check-input" id="active" autocomplete="off" />
                                    </div>

                                </div>
                                <div>
                                    <label class="form-check-label mb-50"
                                        for="cash">{{ translate('Cash Pay') }}</label>
                                    <div class="form-check form-check-primary form-switch">
                                        <input type="checkbox" name="cash" @checked($user?->seller?->cash) disabled
                                            class="form-check-input" id="cash" autocomplete="off" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->bank_name }}" label="Bank Name"
                        name="bank_name" placeholder="Bank Name" inputId="bank_name" disabled />

                    <x-inputs.Multi-Vertical.input value="{{ $user?->seller?->account_number }}" label="Account Number"
                        name="account_number" placeholder="Account Number" inputId="account_number" disabled
                        onkeypress="return isNumberKey(event,15)" />
                    <div class="d-flex gap-1 justify-content-around">
                        <a href="{{ asset('storage/' . $user->seller->portfolio) }}" target="_blank"
                            class="btn btn-lg btn-transparent border-primary">{{ translate('Portfolio File') }}</a>
                        <a href="{{ asset('storage/' . $user->seller->supporting_document) }}" target="_blank"
                            class="btn btn-lg btn-transparent border-primary">{{ translate('Supporting Document') }}</a>
                        <a href="{{ asset('storage/' . $user->seller->marketing_plan) }}" target="_blank"
                            class="btn btn-lg btn-transparent border-primary">{{ translate('Marketing Plan') }}</a>
                    </div>

                    <x-Maps.google label="Select Seller Location" long="{{ $user?->seller?->long ?? '36.287841796875' }}"
                        size="col-12 my-2 border border-1 shadow rounded rounded-2"
                        lat="{{ $user?->seller?->lat ?? '33.49559774486575' }}" editable="false" />

                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
