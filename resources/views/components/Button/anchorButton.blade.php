@props([
    'name' => '',
    'route' => '#',
])


<a {{ $attributes->merge(['class' => 'btn btn-lg fs-3 fw-bolder']) }}
    @if ($route != '') href="{{ $route }}" @endif>
    {{ translate($name) }}
</a>
