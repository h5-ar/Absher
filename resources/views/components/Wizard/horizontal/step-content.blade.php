@props([
    'target' => '',
    'feather' => '',
    'title' => '',
    'subTitle' => '',
    'last' => false,
    'first' => false,
])

<div id="{{ $target }}" class="content" role="tabpanel" aria-labelledby="{{ $target }}-trigger">
    <div class="content-header">
        <h5 class="mb-0 fw-bolder fs-4">{{ translate($title) }}</h5>
        <small class="text-muted fs-5 fw-bolder">{{ translate($subTitle) }}</small>
    </div>
    {{ $slot }}

    @if ($last)
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-prev" type="button">
                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">{{ translate('Previous') }}</span>
            </button>
            <button type="button" class="btn btn-primary" onclick="validateInputs()">{{ translate('Save') }}</button>
        </div>
    @else
        <div
            class="d-flex @if ($first) justify-content-end
        @else
        justify-content-between @endif
        ">
            @if (!$first)
                <button class="btn btn-primary btn-prev" type="button">
                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">{{ translate('Previous') }}</span>
                </button>
            @endif
            <button class="btn btn-primary btn-next" type="button">
                <span class="align-middle d-sm-inline-block d-none">{{ translate('Next') }}</span>
                <i data-feather="arrow-right" class="align-middle justify-self-end ms-sm-25 ms-0"></i>
            </button>
        </div>
    @endif
</div>
