@props([
    'defualt' => false,
])

@if ($defualt)
    <div class="items-list-clone" style="display: none">
        {{ $slot }}
    </div>
@else
    <div class="items-list">
        {{ $slot }}
    </div>
@endif
