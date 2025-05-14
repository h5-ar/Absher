@props([
    'label' => '',
    'placeholder' => '',
    'name' => '',
    'inputId' => '',
    'size' => 'col-md-6 col-12',
    'description' => false,
    'isRequired' => false,
])
{{ logger($isRequired) }}
<div class="{{ $size }}">
    <div class="mb-1">
        <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
            for="{{ $inputId }}">{{ translate($label) }}</label>
        @if ($description)
            <x-SVG.alert-circle description="{{ $description }}" />
        @endif
        <input {{ $attributes->merge(['type' => 'text']) }} value="{{ old($name) }}" id="{{ $inputId }}"
            class="form-control  rounded" placeholder="{{ translate($placeholder) }}" name="{{ $name }}" />
    </div>
</div>
