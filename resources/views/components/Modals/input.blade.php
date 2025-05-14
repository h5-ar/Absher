@props([
    'inputId' => '',
    'inputName' => '',
    'inputType' => '',
    'description' => '',
    'route' => '',
    'method' => 'POST',
    'title' => '',
    'label' => '',
    'value' => '',
    'modalId' => 'inputModal',
])

<div class="modal fade text-start" id="{{ $modalId }}" tabindex="-1" aria-labelledby="inputModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="inputModalTitle">{{ translate($title) }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="{{ $modalId }}Form" action="{{ $route }}" method="POST"
                enctype="multipart/form-data">
                @if (strtolower($method) == 'put')
                    @method('PUT')
                @endif
                @csrf
                <p class="fs-5 fw-bold m-1">
                    {{ translate($description) }}
                </p>
                <div class="modal-body">
                    <label>{{ translate($label) }} </label>
                    <div class="mb-1">
                        <input id="{{ $inputId }}" type="{{ $inputType }}" class="form-control"
                            value="{{ translate($value) }}" name="{{ $inputName }}" {{ $attributes->merge() }} />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ translate('Cancel') }}</button>
                    <input id="sendImage" class="btn btn-primary" type="submit" value="{{ translate('Send') }}">
                    {{-- <button type="submit" class="btn btn-primary"></button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
