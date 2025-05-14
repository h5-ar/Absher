@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'selectId' => '',
    'isRequired' => false,
    'ajaxRoute' => '', // Add a new prop for the AJAX route
    'view' => 'h',
    'size' => 'col-md-6 col-12',
    'description' => false,
])

@if ($view === 'h')
    <div class="row" id="row_{{ $selectId }}">
        <div class="col-12">
            <div class="mb-1 row">
                <div class="col-3 col-sm-3">
                    <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
                        for="{{ $selectId }}">
                        {{ translate($label) }}
                    </label>
                    @if ($description)
                        <x-SVG.alert-circle description="{{ $description }}" />
                    @endif
                </div>
                <div class="col-9 col-sm-9">
                    <select class="form-control select2" multiple="multiple" id="{{ $selectId }}"
                        data-placeholder="{{ translate($placeholder) }}" name="{{ $name }}"
                        {{ $attributes->merge(['autocomplete' => 'off']) }}>
                        {{ $slot }}
                    </select>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="{{ $size }}" id="row_{{ $selectId }}">
        <div class="mb-1">
            <label class="col-form-label fs-5 fw-bolder @if ($isRequired) isRequired @endif"
                for="{{ $selectId }}">{{ translate($label) }}</label>
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
@endif

@push('layout-scripts')
    <script>
        $('#{{ $selectId }}').select2({
            ajax: {
                url: '{{ $ajaxRoute }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query;
                },
                processResults: function(data) {
                    var result = {};
                    if (data.optgroup) {
                        result = {
                            results: groupDataByCategory(data.optgroup),
                        };
                    } else {
                        result = {
                            results: $.map(data.items, function(item) {
                                name = item.name;
                                item.last_name ? name += " " + item.last_name : "";
                                return {
                                    text: name,
                                    id: item.id
                                }
                            })
                        };
                    }
                    return result;

                },
                cache: true
            },
            minimumInputLength: 2,
            escapeMarkup: function(markup) {
                return markup;
            },
        });

        function groupDataByCategory(data) {
            // Assuming your API response has a 'category' property for grouping
            var groupedData = {};

            // Iterate through the data and group by category
            for (var i = 0; i < data.length; i++) {
                var category = data[i].name;

                // If the category doesn't exist in the groupedData, create it
                if (!groupedData[category]) {
                    groupedData[category] = {
                        text: category,
                        children: []
                    };
                }

                // Add the option to the corresponding category
                data[i].stocks.forEach(stock => {
                    groupedData[category].children.push({
                        id: JSON.stringify(stock),
                        text: `{{ translate('SKU') }}: ${stock.sku} , {{ translate('Seller') }} : ${stock.seller.user.name}`
                        // Add any other properties you want to include
                    });
                });
            }

            // Convert the groupedData object into an array
            var resultArray = [];
            for (var key in groupedData) {
                if (groupedData.hasOwnProperty(key)) {
                    resultArray.push(groupedData[key]);
                }
            }

            return resultArray;
        }
    </script>
@endpush
