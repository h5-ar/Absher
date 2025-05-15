<button
    onclick="history.back()"
    {{ $attributes->merge([
        'class' => 'btn btn-outline-secondary fw-bolder fs-5 waves-effect',
        'id' => 'back-btn',
    ]) }}>
    {{ translate('Back') }}
</button>