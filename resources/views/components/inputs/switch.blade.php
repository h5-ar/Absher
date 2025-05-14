@props([
    'label' => '',
    'name' => '',
    'id' => '',
    'checked' => false,
    'labelStyle' => '',
    'labelTitle' => '',
    'translationFile' => 'translation',
    'view' => 'v',
    'description' => false,
])
@push('styles')
    <style>
        .form-check-input:checked {
            background-color: var(--nav-item-sub-selected-background);
        }
    </style>
@endpush

@if ($view == 'h')
    <div class="form-check form-switch">
        <label class="form-check-label mb-50 fs-4 fw-bolder" style="{{ $labelStyle }}"
            title="{{ translate($labelTitle, $translationFile) }}"
            for="{{ $id }}">{{ translate($label, $translationFile) }}</label>
        @if ($description)
            <x-SVG.alert-circle description="{{ $description }}" />
        @endif
        <input type="checkbox" name="{{ $name }}" @if ($checked === 'true' || $checked === '1') checked @endif
            id="{{ $id }}"
            {{ $attributes->merge(['autocomplete' => 'off', 'class' => 'form-check-input']) }} />
    </div>
@else
    <label class="form-check-label mb-50" style="{{ $labelStyle }}"
        title="{{ translate($labelTitle, $translationFile) }}"
        for="{{ $id }}">{{ translate($label, $translationFile) }}</label>
    @if ($description)
        <x-SVG.alert-circle description="{{ $description }}" />
    @endif
    <div class="form-check form-switch">
        <input type="checkbox" name="{{ $name }}" @if ($checked === 'true' || $checked === '1') checked @endif
            id="{{ $id }}"
            {{ $attributes->merge(['autocomplete' => 'off', 'class' => 'form-check-input']) }} />
    </div>
@endif
