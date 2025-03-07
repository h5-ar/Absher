@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Edit Brand') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 text-bold">{{ translate('Edit Brand') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.brands.update', $brand->id) }} ">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <x-inputs.h-input isRequired="true" inputName="name" inputId="name" lable="Name"
                                    placeholder="Brand Name" value="{{ $brand->name }}" description="Enter Brand Name" />
                                <x-inputs.h-input isRequired="true" inputName="name_ar" inputId="name_ar"
                                    description="Enter Brand Name In Arabic" lable="Name in arabic"
                                    placeholder="{{ translate('Brand Name in arabic') }}"
                                    value="{{ getTranslation($brand, 'name') }}" />

                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-2 col-sm-3">
                                            <label class="col-form-label fs-5 fw-bolder isRequired"
                                                for="Image">{{ translate('Image') }}</label>
                                            <x-SVG.alert-circle description="Add Brand Image" />
                                        </div>
                                        <div class="col-10 col-sm-9">
                                            <input type="hidden" name="imageId" id="imageId" autocomplete="off"
                                                value="{{ $brand?->attache?->upload?->id }}">
                                            <div class="d-flex align-items-center justify-content-center w-100">
                                                <img data-bs-toggle="modal" href="#modalFiles" role="button"
                                                    src="{{ asset($brand?->attache?->upload?->url) }}"
                                                    alt="{{ translate('No image found') }}" id="showImage" alt="Image"
                                                    width="300" height="200" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9 offset-sm-3">
                                    <x-Button.submit label="edit" type="button" onclick="validateInputs()" />
                                </div>
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
        $("#reset-btn").click(function(e) {
            e.preventDefault();
            $('#name').val('');
            $('#iamgeId').val('');
            $("#showImage").attr('src', 'https://via.placeholder.com/300x200.png/CCCCCC?text=Click+to+Add+Image');
        });
    </script>


    <script>
        function validateInputs() {
            var form = $('#createForm')[0];

            var rules = {
                _token: Joi.string().required(),

                _method: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                name_ar: Joi.string().required().messages({
                    '*': '{{ translate('Name in arabic is required') }}',
                }),

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
