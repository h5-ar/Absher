@props([
    'route' => '#',
])
<a class="text-danger" onclick="openDeleteModal(this)" data-bs-toggle="modal" deleteUrl="{{ $route }}"
    href="#deleteModal" role="button"> <x-SVG.trash style="width: 1.4rem;height: 1.4rem" /> </a>
