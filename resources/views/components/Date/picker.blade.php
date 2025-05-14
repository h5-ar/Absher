@props([
    'label' => '',
    'dateId' => '',
    'isRequired' => false,
    'description' => false,
])

<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-3 col-sm-3">
                <label class="col-form-label @if ($isRequired) isRequired @endif fs-5 fw-bolder"
                    for="{{ $dateId }}">{{ translate($label) }}</label>
                @if ($description)
                    <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-9 col-sm-9">
                <input type="text" id="{{ $dateId }}" {{ $attributes->merge([]) }}
                    class="form-control flatpickr-basic border border-2 rounded" placeholder="YYYY-MM-DD" />
            </div>
        </div>
    </div>
</div>
