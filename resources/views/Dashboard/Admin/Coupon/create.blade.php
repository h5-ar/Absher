@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Coupon') }}
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
                        <h4 class="card-title fs-2 fw-bolder">{{ translate('Add Coupon') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.coupons.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" placeholder="Coupon Name"
                                    isRequired="true" description="Enter Coupon Name" />

                                <x-inputs.h-input inputName="code" inputId="code" lable="Code" placeholder="Code"
                                    value="{{ old('code') ?? generateNumber('coupons', 'code', 8) }}" isRequired="true"
                                    description="Enter Coupon Code" />
                            </div>

                            <x-inputs.h-select title="Discount Type" name="discount_type" selectId="discount_type"
                                description="Select Discount Type" lable="Discount Type">
                                <x-inputs.option lable="Discount" value="discount" />
                                <x-inputs.option lable="Percentage" value="percentage" />
                            </x-inputs.h-select>

                            <div class="row">
                                <x-inputs.h-input inputName="discount_value" inputId="discount_value" lable="Discount Value"
                                    description="Enter Discount Value" placeholder="Discount Value" isRequired="true"
                                    value='0' onkeypress="return isNumberKey(event)" />
                            </div>

                            <x-inputs.h-select title="On" name="on" selectId="on" lable="On"
                                description="Select What Should This Coupon Apply On">
                                <x-inputs.option lable="All" value="all" />
                                <x-inputs.option lable="Category" value="category" />
                                <x-inputs.option lable="Brand" value="brand" />
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Brands" name="brand_id" selectId="brand_id" lable="Brands"
                                isHidden='true' description="Select Brand">
                                @foreach ($brands as $brand)
                                    <x-inputs.option lable2="{{ $brand->name }}" value="{{ $brand->id }}" />
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Categories" name="sub_category_id" selectId="sub_category_id"
                                lable="Categories" isHidden='true' description="Select Category">
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        <x-inputs.option lable2="{{ $category->name }}" value="{{ $category->id }}" />
                                        @foreach ($category->children as $subCategory)
                                            @if ($subCategory->name == 'main')
                                                <x-inputs.option lable2="{{ $category->name }}"
                                                    value="{{ $subCategory->id }}" />
                                            @else
                                                <x-inputs.option lable2="{{ $subCategory->name }}"
                                                    value="{{ $subCategory->id }}" />
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Coupon Type" name="type" selectId="type" lable="Type"
                                description="Select The Type Of The Coupon">
                                <x-inputs.option lable="Private" value="private" />
                                <x-inputs.option lable="Public" value="public" />
                            </x-inputs.h-select>


                            <x-inputs.h-multi-select-search lable="Users" name="users[]" label="Users" isRequired="true"
                                description="Search Users By Name To Add" placeholder="Click to add users"
                                selectId="users" ajaxRoute="{{ route('dashboard.coupons.searchUsers') }}" required>
                            </x-inputs.h-multi-select-search>

                            <x-inputs.h-input inputName="times" inputId="times" lable="Times Count"
                                description="Enter Max Used Count" placeholder="Times Count"
                                onkeypress="return isNumberKey(event)" />

                            <x-Date.picker name="start_date" dateId="start_date" label="Start Date" required
                                isRequired="true" description="Select Coupon Start Date" />

                            <x-Date.picker name="end_date" dateId="end_date" label="End Date" required isRequired="true"
                                description="Select Coupon End Date" />


                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit type="button" onclick="validateInputs()" />
                                <x-Button.rest />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-Files.single inputFormId="imageId" showTagId="showImage" />
    </x-Content.normal>
@endsection

@push('layout-scripts')
    <script>
        $('#discount_type').change(function(e) {
            e.preventDefault();
            var input = document.getElementById('discount_value');
            if ($(this).val() == 'percentage') {
                input.placeholder = '{{ translate('Discount Value') }} %'
            } else {
                input.placeholder = '{{ translate('Discount Value') }} '
            }
        });

        $(document).ready(function() {
            $("#row_users").hide();
        });

        $("#discount_type").change(function(e) {
            $("#discount_value").val(0);
        });

        $("#type").change(function(e) {
            $("#type").val();
            $("#users").val('').trigger('change');
        });

        $("#type").change(function(e) {
            let type = $("#type").val();
            if (type == 'private') {
                $("#row_users").show(500);
            } else {
                $("#users").val('');
                $("#row_users").hide(500);
            }
        });

        $("#on").change(function(e) {
            var value = e.target.value;
            if (value == 'all') {
                $('#row_brand_id').attr('hidden', true);
                $('#row_sub_category_id').attr('hidden', true);
            } else if (value == 'brand') {
                $('#row_brand_id').removeAttr('hidden');
                $('#row_product_id').attr('hidden', true);
                $('#row_sub_category_id').attr('hidden', true);
            } else {
                $('#row_sub_category_id').removeAttr('hidden');
                $('#row_product_id').attr('hidden', true);
                $('#row_brand_id').attr('hidden', true);
            }
            return;
        });
    </script>

    <script>
        function validateInputs() {
            var form = $('#createForm')[0];
            var usedCodes = @json($codes);
            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                code: Joi.string().required().disallow(...usedCodes).messages({
                    'any.invalid': '{{ translate("The provided coupon\'s code is not allowed") }}',
                    "string.empty": "{{ translate('Code can\'t be empty') }}",
                }),

                discount_type: Joi.string().valid('percentage', 'discount').required().messages({
                    '*': "{{ translate('Discont type is required') }}"
                }),

                discount_value: Joi.number().when(Joi.ref('discount_type'), {
                    is: 'percentage',
                    then: Joi.number().max(100).min(1).messages({
                        '*': '{{ translate('Discount value must be between 1 and 100') }}'
                    }),
                    otherwise: Joi.number().min(1).messages({
                        '*': '{{ translate('Discount value must grater than or equal 0 and less than price') }}'
                    }),
                }),

                on: Joi.string().valid('all', 'category', 'brand').required(),


                brand_id: Joi.string().when(Joi.ref('on'), {
                    is: 'brand',
                    then: Joi.required().messages({
                        '*': '{{ translate('Please Select Brand') }}'
                    }),
                    otherwise: Joi.allow('', null),
                }),

                sub_category_id: Joi.string().when(Joi.ref('on'), {
                    is: 'category',
                    then: Joi.required().messages({
                        '*': '{{ translate('Please Select Category') }}'
                    }),
                    otherwise: Joi.allow('', null),
                }),

                type: Joi.string().valid('private', 'public').required(),

                times: Joi.number().min(1).allow('', null).required(),
                users: Joi.array().when(Joi.ref('type'), {
                    is: 'private',
                    then: Joi.array().items(Joi.string().required()),
                    otherwise: Joi.allow('', null),
                }),
                start_date: Joi.date().allow(null, ''),
                end_date: Joi.date().allow(null, ''),
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());

            delete formDataObject['users[]'];
            formDataObject['users'] = $('#users').val();

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
                if (label == 'users') {
                    label = 'users[]'
                }
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
