@props([
    'name' => '',
    'route' => '#',
])

@push('styles')
    <style>
        .customAddButton {
            background-color: var(--nav-item-sub-selected-background);
            color: whitesmoke;
        }

        .customAddButton:hover {
            background-color: var(--side-background-color);
            color: whitesmoke;
        }
    </style>
@endpush

<div {{ $attributes->merge(['class' => 'col-md-3 col-sm-4 col-xs-4 col-3']) }}>
    <x-Button.anchorButton class="customAddButton" name="{{ $name }}"
        route="{{ $route }}" />
</div>
