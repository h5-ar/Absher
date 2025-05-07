@props([
    'name' => '',
    'selectId' => '',
    'lable' => '',
    'title' => 'title',
    'isHidden' => false,
    'size' => 'col-md-6 col-12',
    'description' => false,
    'isRequired' => false,
])

<div class="{{ $size }}" id="row_{{ $selectId }}" @if ($isHidden) hidden @endif>
    <div class="mb-1">
        <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
            for="{{ $selectId }}">{{ translate($lable) }}</label>
        @if ($description)
            <x-SVG.alert-circle description="{{ $description }}" />
        @endif
        <select data-placeholder="{{ translate($title) }}" autocomplete="off" class="select2 form-select rounded"
            name="{{ $name }}" id="{{ $selectId }}" {{ $attributes->merge([]) }}>
            <option id="Default_{{ $selectId }}" selected></option>
            {{ $slot }}
        </select>
    </div>
</div>
