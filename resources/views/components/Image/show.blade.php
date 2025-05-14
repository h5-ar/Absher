@props([
    'url' => '',
    'classes' => 'border border-3 rounded rounded-3',
])
<div class="d-flex align-items-center justify-content-center w-100">
    <a @if (asset($url) != asset('')) onclick="openImageModal(this)" data-bs-toggle="modal" href="#imageModal" role="button"@else style="cursor: default" @endif
        data-url="{{ asset($url) }}">
        <img class="{{ $classes }}" {{ $attributes->merge([]) }} src="{{ asset($url) }}"
            alt="{{ translate('No image found') }}" height="90" width="90" />
    </a>
</div>

@section('show-image')
    <x-Modals.image />
@endsection

@push('layout-scripts')
    <script>
        function openImageModal(elem) {
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'), {
                keyboard: false
            })
            $("#modalImg").attr('src', $(elem).data('url'));
        }
    </script>
@endpush
