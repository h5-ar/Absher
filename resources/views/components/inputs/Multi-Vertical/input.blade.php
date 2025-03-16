@props([
    'label' => '',
    'placeholder' => '',
    'name' => '',
    'inputId' => '',
    'size' => 'col-12', 
    'description' => false,
    'isRequired' => false,
])

<div class="{{ $size }}">
    <div class="mb-1 row"> 
        <div class="col-sm-3"> 
            <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
                for="{{ $inputId }}">{{ translate($label) }}</label>
            @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
            @endif
        </div>
        <div class="col-sm-9"> 
            <input {{ $attributes->merge(['type' => 'text']) }} value="{{ old($name) }}" id="{{ $inputId }}"
                class="form-control rounded" placeholder="{{ translate($placeholder) }}" name="{{ $name }}" />
        </div>
    </div>
</div>
