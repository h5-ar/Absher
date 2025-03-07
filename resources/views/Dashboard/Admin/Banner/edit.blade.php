@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Edit Banner') }}
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
                        <h4 class="card-title fs-2 text-bold">{{ translate('Edit Banner') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.banners.update', $banner->id) }} ">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" isRequired="true"
                                    description="Enter Banner Name" placeholder="{{ translate('Banner Name') }}"
                                    value="{{ $banner->name }}" />


                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    isRequired="true" description="Enter  Banner Name In Arabic"
                                    placeholder="{{ translate('Banner Name in arabic') }}"
                                    value="{{ getTranslation($banner, 'name') }}" />
                            </div>

                            <x-inputs.h-select title="Type" name="type" selectId="type" lable="Type"
                                description="Select The Banner Type">

                                <option class="form-control border border-2 rounded" value="product"
                                    @selected($banner->type->value == 1)>
                                    {{ translate('Product') }}
                                </option>
                                <option class="form-control border border-2 rounded" value="category"
                                    @selected($banner->type->value == 2)>
                                    {{ translate('Category') }}
                                </option>
                                <option class="form-control border border-2 rounded" value="brand"
                                    @selected($banner->type->value == 3)>
                                    {{ translate('Brand') }}
                                </option>

                            </x-inputs.h-select>

                            {{-- options to select category , brand  or product when select type  --}}
                            <x-inputs.h-select title="Products" name="product_id" selectId="product_id" lable="Products"
                                description="Select The Product" isHidden='true'>

                                @foreach ($products as $product)
                                    <option class="form-control border border-2 rounded" value="{{ $product->id }}"
                                        @selected($product->id == $banner->product_id)>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Brands" name="brand_id" selectId="brand_id" lable="Brands"
                                description="Select The Brand" isHidden='true'>
                                @foreach ($brands as $brand)
                                    <option class="form-control border border-2 rounded" value="{{ $brand->id }}"
                                        @selected($brand->id == $banner->brand_id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </x-inputs.h-select>

                            <x-inputs.h-select title="Categories" name="sub_category_id" selectId="sub_category_id"
                                description="Select The Category" lable="Categories" isHidden='true'>
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->children as $subCategory)
                                            @if ($subCategory->name == 'main')
                                                <option class="form-control border border-2 rounded"
                                                    value="{{ $subCategory->id }}" @selected($subCategory->id == $banner->sub_category_id)>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @else
                                                <option class="form-control border border-2 rounded"
                                                    value="{{ $subCategory->id }}" @selected($subCategory->id == $banner->sub_category_id)>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </x-inputs.h-select>
                            {{-- End --}}
                            <x-Date.picker isRequired="true" name="start_date" dateId="start_date"
                                description="Select Banner Start Date" value="{{ $banner->start_date }}" label="Start Date"
                                required />

                            <x-Date.picker isRequired="true" name="end_date" dateId="end_date"
                                description="Select Banner End Date" value="{{ $banner->end_date }}" label="End Date"
                                required />

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-2 col-sm-3">
                                        <label class="col-form-label fs-5 fw-bolder isRequired"
                                            for="Image">{{ translate('Image') }}</label>
                                        <x-SVG.alert-circle description="Add Banner Image" />
                                    </div>
                                    <div class="col-10 col-sm-9">
                                        <input type="hidden" name="imageId" id="imageId" autocomplete="off"
                                            value="{{ $banner?->attache?->upload?->id }}">
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <img data-bs-toggle="modal" href="#modalFiles" role="button"
                                                src="{{ $banner?->attache?->upload?->url }}"
                                                alt="{{ translate('No image found') }}" id="showImage" alt="Image"
                                                width="300" height="200" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit type="button" onclick="validateInputs()" label="edit" />
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
        });

        $(function() {
            var value = '{{ str()->lower($banner->type->name) }}';
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

                _method: Joi.string().required(),

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
