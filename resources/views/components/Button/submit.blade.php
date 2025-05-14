@props([
    'label' => 'submit',
])

@push('styles')
    <style>
        .customSubmitButton{
            background-color:var(--nav-item-sub-selected-background);
            color:whitesmoke;
        }
        .customSubmitButton:hover {
            background-color: var(--side-background-color);
            color:whitesmoke;
        }
    </style>
@endpush

<button
    {{ $attributes->merge([
        'class' => 'btn fw-bolder fs-5 me-1 waves-effect waves-float waves-light customSubmitButton',
        'type' => 'submit',
        'id' => 'submit-btn',
    ]) }}>
    {{ translate($label) }}
</button>
