@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Add Bus') }}
@endsection

@push('scripts')
<script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
@endpush

@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add Bus') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('bus.store') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="type" inputId="type" lable="Type"
                                description="Enter Type Bus " placeholder="{{ translate('Type Bus') }}"
                                isRequired="true" />

                            <x-inputs.h-input inputName="seats_count" inputId="seats_count" lable="Seats Count"
                                description="Enter Seats Count" placeholder="{{ translate('Seats Count') }}"
                                isRequired="true" />

                        </div>

                        <div class="col-sm-9 offset-sm-3">
                            <x-Button.submit type="button" onclick="validateInputs()" />
                            <x-Button.rest />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection
@push('layout-scripts')
<script>
    function validateInputs() {
        var form = $('#createForm')[0];
        var rules = {
            _token: Joi.string().required(),
            type: Joi.string().required().messages({
                '*': '{{ translate("type in is required") }}',
            }),

            _token: Joi.string().required(),
            seats_count: Joi.string().required().messages({
                '*': '{{ translate("seats count in is required") }}',
            }),
        };
        var data = new FormData(form);
        var formDataObject = Object.fromEntries(data.entries());

        for (const key in formDataObject) {
            if (key.startsWith('subCategories')) {
                switch (true) {
                    case key.includes('type'):
                        rules[key] = Joi.string().required().messages({
                            '*': '{{ translate("type is required") }}',
                        });
                        break;
                    case key.includes('seats_count'):
                        rules[key] = Joi.string().required().messages({
                            '*': '{{ translate("seats count is required ") }}',
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