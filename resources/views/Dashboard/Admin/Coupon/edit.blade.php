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
                        <form id="editForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.coupons.update', $coupon->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" placeholder="Coupon Name"
                                    value="{{ $coupon->name }}" isRequired="true" description="Enter Coupon Name" />

                                <x-inputs.h-input inputName="code" inputId="code" lable="Code" placeholder="Code"
                                    value="{{ generateNumber('coupons', 'code', 8) }}" isRequired="true"
                                    value="{{ $coupon->code }}" description="Enter Coupon Code" />
                            </div>

                            <div class="row" id="row_discount_type">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="discount_type">{{ translate('Discount Type') }}</label>
                                            <x-SVG.alert-circle description="Select Discount Type" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select data-placeholder="{{ translate('Discount Type') }}"
                                                class="select2 form-select" name="discount_type" id="discount_type"
                                                autocomplete="off">
                                                <option class="form-control rounded" value="discount"
                                                    @selected($coupon->discount_type->value == 'discount')>
                                                    {{ translate('Discount') }}
                                                </option>
                                                <option class="form-control rounded" value="percentage"
                                                    @selected($coupon->discount_type->value == 'percentage')>
                                                    {{ translate('Percentage') }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <x-inputs.h-input inputName="discount_value" inputId="discount_value" lable="Discount Value"
                                    placeholder="Discount Value" isRequired="true" value='{{ $coupon->discount_value }}'
                                    onkeypress="return isNumberKey(event)" description="Enter Discount Value" />
                            </div>


                            <div class="row" id="row_discount_type">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="discount_type">{{ translate('On') }}</label>
                                            <x-SVG.alert-circle description="Select What Should This Coupon Apply On" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select data-placeholder="{{ translate('On') }}" class="select2 form-select"
                                                name="on" id="on" autocomplete="off">
                                                <option class="form-control rounded" value="all"
                                                    @selected(!isset($coupon->couponable))>
                                                    {{ translate('All') }}
                                                </option>
                                                <option class="form-control rounded" value="category"
                                                    @selected(class_basename($coupon?->couponable) == 'Category')>
                                                    {{ translate('Category') }}
                                                </option>
                                                <option class="form-control rounded" value="brand"
                                                    @selected(class_basename($coupon?->couponable) == 'Brand')>
                                                    {{ translate('Brand') }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="row_brand_id" hidden>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="brand_id">{{ translate('Brands') }}</label>
                                            <x-SVG.alert-circle description="Select Brand" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select data-placeholder="{{ translate('Brands') }}"
                                                class="select2 form-select" name="brand_id" id="brand_id"
                                                autocomplete="off">
                                                @foreach ($brands as $brand)
                                                    <option class="form-control rounded" value="{{ $brand->id }}"
                                                        @selected($coupon->couponable?->id == $brand->id)>
                                                        {{ translate($brand->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="row_sub_category_id" hidden>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="sub_category_id">{{ translate('Categories') }}</label>
                                            <x-SVG.alert-circle description="Select Category" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select data-placeholder="{{ translate('Categories') }}"
                                                class="select2 form-select" name="sub_category_id" id="sub_category_id"
                                                autocomplete="off">
                                                @foreach ($categories as $category)
                                                    <optgroup label="{{ $category->name }}">
                                                        <option class="form-control rounded" value="{{ $category->id }}"
                                                            @selected($coupon->couponable?->id == $category->id)>
                                                            {{ translate($category->name) }}
                                                        </option>
                                                        @foreach ($category->children as $subCategory)
                                                            <option class="form-control rounded"
                                                                value="{{ $subCategory->id }}"
                                                                @selected($coupon->couponable?->id == $subCategory->id)>
                                                                {{ translate($subCategory->name) }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="row_type">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="type">{{ translate('Type') }}</label>
                                            <x-SVG.alert-circle description="Select The Type Of The Coupon" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select data-placeholder="{{ translate('Type') }}"
                                                class="select2 form-select" name="type" id="type"
                                                autocomplete="off">
                                                <option class="form-control rounded" value="private"
                                                    @selected($coupon?->type?->value == 1)>
                                                    {{ translate('Private') }}
                                                </option>

                                                <option class="form-control rounded" value="public"
                                                    @selected($coupon?->type?->value == 0)>
                                                    {{ translate('Public') }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="row_users">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-3 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired" for="users">
                                                {{ translate('Users') }}
                                            </label>
                                            <x-SVG.alert-circle description="Search Users By Name To Add" />
                                        </div>
                                        <div class="col-9 col-sm-9">
                                            <select class="form-control select2" multiple="multiple" id="users"
                                                data-placeholder="Click to add users" name="users[]" autocomplete="off">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-inputs.h-input inputName="times" inputId="times" lable="Times Count"
                                placeholder="Times Count" value='{{ $coupon->times }}'
                                onkeypress="return isNumberKey(event)" description="Enter Max Used Count" />

                            <x-Date.picker name="start_date" dateId="start_date" label="Start Date" required
                                value="{{ $coupon->start_date }}" isRequired="true"
                                description="Select Coupon Start Date" />

                            <x-Date.picker name="end_date" dateId="end_date" label="End Date" required isRequired="true"
                                value="{{ $coupon->end_date }}" description="Select Coupon End Date" />


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
        $(document).ready(function() {
            $("#row_users").hide();

            if ('{{ class_basename($coupon->couponable) == 'Category' }}') {
                $('#row_sub_category_id').removeAttr('hidden');

            } else if ('{{ class_basename($coupon->couponable) == 'Brand' }}') {
                $('#row_brand_id').removeAttr('hidden');

            }

            if ('{{ $coupon->type }}' == 1) {
                $("#row_users").show();
            }
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

        $(document).ready(function() {
            var preloadedData = [];

            @foreach ($coupon->users as $user)
                preloadedData.push({
                    id: {{ $user->id }},
                    text: '{{ $user->name }} {{ $user->last_name }}',
                    'selected': true
                });
            @endforeach

            $('#users').select2({
                data: preloadedData,
                ajax: {
                    url: '{{ route('dashboard.coupons.searchUsers') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.items, function(item) {
                                name = item.name;
                                item.last_name ? name += " " + item.last_name : "";
                                return {
                                    text: name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                escapeMarkup: function(markup) {
                    return markup;
                },
            })
        });
    </script>
    <script>
        function validateInputs() {
            var form = $('#editForm')[0];
            var usedCodes = @json($codes);

            var rules = {
                _token: Joi.string().required(),
                _method: Joi.string().required(),
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
