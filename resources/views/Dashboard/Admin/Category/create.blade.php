@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Category') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 text-bold">{{ translate('Add Category') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.categories.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name"
                                    description="Enter Category Name" placeholder="{{ translate('Category Name') }}"
                                    isRequired="true" />
                            </div>
                            <div class="row">
                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    description="Enter Category Name In Arabic"
                                    placeholder="{{ translate('Category Name in arabic') }}" isRequired="true" />
                            </div>

                            <x-inputs.h-gender-select description="Select Category Gender" />

                            <x-Image.single description="Add Category Image" />

                            <h3 class="mt-4">{{ translate('Add Sub Categories') }}</h3>
                            <hr class="mb-4" />

                            <div class="row">
                                <x-Repeater.container name="subCategories">
                                    <x-Repeater.item-list defualt='true'>
                                        <x-inputs.h-input-repeater inputName="name" inputId="name" lable="Name"
                                            description="Enter Category Name" placeholder="{{ translate('Category Name') }}"
                                            isRequired="true" />

                                        <x-inputs.h-input-repeater inputName="name_ar" inputId="name_ar"
                                            description="Enter Category Name In Arabic" lable="Name In Arabic"
                                            isRequired="true" placeholder="{{ translate('Category Name In Arabic') }}" />

                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-2 col-sm-3">
                                                    <label class="col-form-label fs-5 fw-bolder isRequired"
                                                        for="Image">{{ translate('Image') }}</label>
                                                    <x-SVG.alert-circle description="Add Category Image" />
                                                </div>
                                                <div class="col-10 col-sm-9">
                                                    <input type="hidden" name="" id=""
                                                        data-orginal-name="imageId" data-orginal-id="imageId"
                                                        autocomplete="off">

                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img data-bs-toggle="modal" href="#modalFilesRepeater"
                                                            class="rounded rounded-2 shadow" role="button"
                                                            @if (app()->getLocale() == 'ar') src="{{ asset('app-assets/images/clickToAddAr.png') }}"
                                                            @else src="{{ asset('app-assets/images/clickToAddEn.png') }}" @endif
                                                            id="" alt="Image" width="300" height="200" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mb-2">
                                            <button class="btn btn-sm btn-danger" onclick="deleteItem(this)"
                                                type="button"><i data-feather="trash"></i></button>
                                        </div>
                                    </x-Repeater.item-list>
                                </x-Repeater.container>
                            </div>

                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit type="button" onclick="validateInputs()" />
                                <x-Button.rest />
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <x-Files.single inputFormId="imageId" showTagId="showImage" />
        <x-Files.single-repeater />
    </x-Content.normal>
@endsection



@push('layout-scripts')
    <script>
        function validateInputs() {
            var form = $('#createForm')[0];
            var categories = @json($categories)

            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().disallow(...categories).required().messages({
                    'any.invalid': '{{ translate('This name has been taken before') }}',
                    "string.empty": "{{ translate('Name is required') }}",
                }),

                name_ar: Joi.string().required().messages({
                    '*': '{{ translate('Name in arabic is required') }}',
                }),

                gender: Joi.string().required().messages({
                    '*': '{{ translate('Gender is required') }}',
                }),


                imageId: Joi.string().required().messages({
                    '*': '{{ translate('Image is required') }}',
                }),
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());

            for (const key in formDataObject) {
                if (key.startsWith('subCategories')) {
                    switch (true) {
                        case key.includes('name_ar'):
                            rules[key] = Joi.string().required().messages({
                                '*': '{{ translate('Name in arabic is required') }}',
                            });
                            break;
                        case key.includes('name'):
                            rules[key] = Joi.string().disallow(...categories).required().messages({
                                'any.invalid': '{{ translate('This name has been taken before') }}',
                                "string.empty": "{{ translate('Name is required') }}",
                            });
                            break;
                        case key.includes('imageId'):
                            rules[key] = Joi.string().required().messages({
                                '*': '{{ translate('Image is required') }}',
                            });
                            break;
                    }
                }
            }

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
