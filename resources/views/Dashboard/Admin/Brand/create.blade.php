@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Brand') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 fw-bolder text-bold">{{ translate('Add Brand') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.brands.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" isRequired="true"
                                    placeholder="{{ translate('Brand Name') }}" description="Enter Brand Name" />
                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    isRequired="true" placeholder="{{ translate('Brand Name in arabic') }}"
                                    description="Enter Brand Name In Arabic" />
                                <x-Image.single description="Add Brand Image" />
                                <div class="col-sm-9 offset-sm-3">
                                    <x-Button.submit onclick="validateInputs()" type="button" />
                                    <x-Button.rest />
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
        function validateInputs() {
            var form = $('#createForm')[0];

            var rules = {
                _token: Joi.string().required(),

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
