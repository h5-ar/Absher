@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'selectId' => '',
    'isRequired' => false,
])

<div class="row" id="row_{{ $selectId }}">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-3 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder @if($isRequired)
                isRequired
                @endif" for="{{ $selectId }}">{{ translate($label) }}</label>
            </div>
            <div class="col-9 col-sm-9">
                <select class="select2 form-select" multiple="multiple" id="{{ $selectId }}"
                    data-placeholder="{{ $placeholder }}" name="{{ $name }}" autocomplete="off">
                    {{ $slot }}
                </select>
            </div>
        </div>
    </div>
</div>

@push('layout-scripts')
    <script>
        $('#{{ $selectId }}').change(function(e) {
            e.preventDefault();
            var selectedOptions = $(this).find('option:selected');
            // var prev =  $('#row_{{ $selectId }}').prev();

            // console.log(prev);
            if (selectedOptions.length > 5) {
                // $('#row_{{ $selectId }}').replaceWith(prev);
            }
        });
        $('#row_{{ $selectId }}').change(function(e) {
            e.preventDefault();
            // console.log($(this).prev());
        });
        $('#row_{{ $selectId }} input[type="search"]').keyup(function(e) {
            e.preventDefault();
            const option = document.createElement("option");
            option.value = 'asdf';
            option.text = 'asdfa';
            $('#{{ $selectId }}').append(option);
        });
    </script>
@endpush
