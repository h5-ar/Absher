@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Banner') }}
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
                        <h4 class="card-title fs-2 fw-bolder">{{ translate('Add Banner') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.banners.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" placeholder="Banner Name"
                                    description="Enter Banner Name" isRequired="true" />

                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    description="Enter Banner Name In Arabic"
                                    placeholder="{{ translate('Banner Name in arabic') }}" isRequired="true" />
                            </div>

                            <x-inputs.h-select title="Type" name="type" selectId="type" lable="Type"
                                description="Select The Banner Type">
                                <x-inputs.option lable="Product" value="product" />
                                <x-inputs.option lable="Category" value="category" />
                                <x-inputs.option lable="Brand" value="brand" />
                            </x-inputs.h-select>

                            {{-- options to select category , brand  or product when select type  --}}
                            <x-inputs.h-select title="Products" name="product_id" selectId="product_id" lable="Products"
                                isHidden='true' description="Select The Product">
                                @foreach ($products as $product)
                                    <x-inputs.option lable2="{{ $product->name }}" value="{{ $product->id }}" />
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Brands" name="brand_id" selectId="brand_id" lable="Brands"
                                isHidden='true' description="Select The Brand">
                                @foreach ($brands as $brand)
                                    <x-inputs.option lable2="{{ $brand->name }}" value="{{ $brand->id }}" />
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Categories" name="sub_category_id" selectId="sub_category_id"
                                description="Select The Category" lable="Categories" isHidden='true'>
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
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
                            {{-- End --}}

                            <x-Date.picker name="start_date" dateId="start_date" label="Start Date" required
                                isRequired="true" description="Select Banner Start Date" />

                            <x-Date.picker name="end_date" dateId="end_date" label="End Date" required isRequired="true"
                                description="Select Banner End Date" />

                            <x-Image.single description="Add Banner Image" />

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
        $("#type").change(function(e) {
            var value = e.target.value;
            if (value == 'product') {
                $('#row_product_id').removeAttr('hidden');
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
            var currentDate = '{{ now()->format('Y-m-d') }}';
            var start_date = $('#start_date').val();
            var nextDate = new Date(start_date);

            nextDate.setDate(nextDate.getDate() + 1);

            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                name_ar: Joi.string().required().messages({
                    '*': '{{ translate('Name in arabic is required') }}',
                }),

                type: Joi.string().valid('brand', 'category', 'product').required().messages({
                    '*': '{{ translate('Banner type is required') }}',
                }),

                product_id: Joi.string().when(Joi.ref('type'), {
                    is: 'product',
                    then: Joi.required().messages({
                        '*': '{{ translate('Please Select Category') }}'
                    }),
                    otherwise: Joi.allow('', null),
                }),

                sub_category_id: Joi.string().when(Joi.ref('type'), {
                    is: 'category',
                    then: Joi.required().messages({
                        '*': '{{ translate('Please Select Category') }}'
                    }),
                    otherwise: Joi.allow('', null),
                }),

                brand_id: Joi.string().when(Joi.ref('type'), {
                    is: 'brand',
                    then: Joi.required().messages({
                        '*': '{{ translate('Please Select Category') }}'
                    }),
                    otherwise: Joi.allow('', null),
                }),

                start_date: Joi.date().min(currentDate).required(),
                end_date: Joi.date().min(nextDate.toLocaleDateString('zh-Hans-CN')).required(),

                imageId: Joi.string().required().messages({
                    '*': '{{ translate('Image is required') }}',
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
