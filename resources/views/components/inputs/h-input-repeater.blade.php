@props([
    'inputSize' => 'col-12',
    'type' => 'text',
    'lable' => '',
    'inputId' => '',
    'inputName' => '',
    'placeholder' => '',
    'value' => '',
    'isRequired' => false,
    'disabled' => '',
    'description' => false,
])

<div class="{{ $inputSize }}">
    <div class="mb-1 row">
        <div class="col-sm-3">
            <label class="col-form-label fs-5 fw-bolder @if ($isRequired == 'true') isRequired @endif"
                for="{{ $inputId }}">{{ translate($lable) }}</label>
            @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
            @endif
        </div>
        <div class="col-sm-9">
            <input autocomplete="off" type="{{ $type }}" id=""
                class="form-control  rounded @error($inputName) is-invalid @enderror" {{ $disabled }}
                value="{{ $value ?? old($inputName) }}" name="" placeholder="{{ translate($placeholder) }}"
                data-orginal-name="{{ $inputName }}" data-orginal-id="{{ $inputId }}"
                @if ($isRequired == 'true') required @endif>
        </div>
    </div>
</div>
