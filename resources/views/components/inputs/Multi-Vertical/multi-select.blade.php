@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'selectId' => '',
    'size' => 'col-md-6 col-12',
    'maxinput' => '10',
    'writeable' => false,
    'description' => false,
])

<div class="{{ $size }}" id="row_{{ $selectId }}">
    <div class="mb-1 mt-1">
        <label class="form-label fs-5 fw-bolder" for="{{ $selectId }}">{{ translate($label) }}</label>
        @if ($description)
            <x-SVG.alert-circle description="{{ $description }}" />
        @endif
        <select {{ $attributes->merge(['autocomplete' => 'off']) }} class="select2 form-select rounded"
            multiple="multiple" id="{{ $selectId }}" data-placeholder="{{ translate($placeholder) }}"
            name="{{ $name }}">
            {{ $slot }}
        </select>
    </div>
</div>

@if ($writeable)
    @push('layout-scripts')
        <script>
            $("#{{ $selectId }}").select2({
                tags: true,
                insertTag: function(data, tag) {
                    data.push(tag);
                },
                maximumSelectionLength: parseFloat('{{ $maxinput }}'),
                minimumSelectionLength: 1
            });
        </script>
    @endpush
@endif
