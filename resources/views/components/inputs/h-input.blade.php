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
        <div class="col-3 col-sm-3">
            <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
                for="{{ $inputId }}">{{ translate($lable) }}</label>
            @if ($description)
            <x-SVG.alert-circle stroke="2" description="{{ $description }}" />
            @endif

        </div>

        <div class="col-9 col-sm-9">
            <input autocomplete="off" type="{{ $type }}" id="{{ $inputId }}" {{ $attributes->merge([]) }}
                class="form-control @error($inputName) is-invalid @enderror rounded"
                value="{{ $value ?? old($inputName) }}" name="{{ $inputName }}" {{ $disabled }}
                placeholder="{{ translate($placeholder) }}" @if ($isRequired=='true' ) required @endif>

            @error($inputName)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
