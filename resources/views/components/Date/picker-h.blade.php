@props([
    'label' => '',
    'dateId' => '',
    'isRequired' => false,
    'description' => false,
])

<div class="col-md-6 col-12">
    <div class="mb-1">
        <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
            for="{{ $dateId }}">{{ translate($label) }}</label>
        @if ($description)
            <x-SVG.alert-circle description="{{ $description }}" />
        @endif

        <input type="text" id="{{ $dateId }}" {{ $attributes->merge([]) }} class="form-control flatpickr-basic"
            placeholder="YYYY-MM-DD" />
    </div>
</div>
