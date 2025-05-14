@props([
    'target'    => '',
    'feather'   => 'file-text',
    'title'     => '',
    'subTitle'  => '',
    'next'      => true
])

<div class="step" data-target="#{{ $target }}" role="tab" id="{{ $target }}-trigger">
    <button type="button" class="step-trigger">
        <span class="bs-stepper-box">
            <i data-feather="{{ $feather }}" class="font-medium-3"></i>
        </span>
        <span class="bs-stepper-label">
            <span class="bs-stepper-title fw-bolder fs-4">{{ translate($title) }}</span>
            <span class="bs-stepper-subtitle fw-bolder fs-5">{{ translate($subTitle) }}</span>
        </span>
    </button>
</div>
@if($next===true)
<div class="line">
    <i data-feather="chevron-right" class="font-medium-2"></i>
</div>
@endif
