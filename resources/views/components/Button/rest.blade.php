<button
    {{ $attributes->merge([
        'class' => 'btn btn-outline-secondary fw-bolder fs-5 waves-effect',
        'type' => 'reset',
        'id' => 'reset-btn',
    ]) }}>{{ translate('Reset') }}</button>
