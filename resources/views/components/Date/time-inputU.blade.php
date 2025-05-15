@props([
'typeValue'=>'',
'label' => '',
'dateId' => '',
'isRequired' => false,
'description' => false,
'enableTime' => true,
'time_24hr' => true,
'dateFormat' => 'Y-m-d H:i',
])

<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-3 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
                    for="{{ $dateId }}">{{ translate($label) }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-9 col-sm-9">
                <input value="{{$typeValue}}" type="text" id="{{ $dateId }}" {{ $attributes->merge([]) }}
                    class="form-control flatpickr-basic border border-2 rounded" placeholder="YYYY-MM-DD HH:MM"
                    data-enable-time="{{ $enableTime }}"
                    data-time_24hr="{{ $time_24hr }}"
                    data-date-format="{{ $dateFormat }}" />
            </div>
        </div>
    </div>
</div>

