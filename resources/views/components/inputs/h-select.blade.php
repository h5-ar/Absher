@props([
    'name' => '',
    'selectId' => '',
    'lable' => '',
    'title' => 'title',
    'isHidden' => false,
    'description' => false,
])

<div class="row" id="row_{{ $selectId }}" @if ($isHidden) hidden @endif>
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-3 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired"
                    for="{{ $selectId }}">{{ translate($lable) }}</label>
                @if ($description)
                    <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-9 col-sm-9">
                <select data-placeholder="{{ translate($title) }}" class="select2 form-select" name="{{ $name }}"
                    id="{{ $selectId }}" autocomplete="off">
                    <option id="Default_{{ $selectId }}" selected></option>
                    {{ $slot }}
                </select>
            </div>
        </div>
    </div>
</div>
