@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Offer') }}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-pickadate.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush


@section('content')
    <x-Content.normal>
        <form id="createForm" class="form" method="POST" action="{{ route('dashboard.offers.store') }}">
            @csrf

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ translate('Add Offer') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-inputs.Multi-Vertical.input label="name" name="name" placeholder="Offer Name" inputId="name"
                            isRequired="true" description="Enter Offer Name" required isRequired="true" />

                        <x-inputs.Multi-Vertical.input label="Name in Arabic" name="name_ar" isRequired="true"
                            description="Enter Offer Name In Arabic" placeholder="Offer Name In Arabic" inputId="name_ar"
                            required />

                        <x-inputs.Multi-Vertical.input label="Value of Offer" name="value" inputmode="numeric"
                            isRequired="true" description="Enter The Value Of The Offer" value="0"
                            onkeypress="return isNumberKey(event)" placeholder="Min Quantity To Display" inputId="value" />

                        <x-inputs.Multi-Vertical.select title="Offer Type" name="type" selectId="type" lable="Offer Type"
                            isRequired="true" required description="Enter The Type Of The Offer">
                            <x-inputs.option lable="Gift" value="gift" />
                            <x-inputs.option lable="Discount" value="discount" />
                            <x-inputs.option lable="Percentage" value="percentage" />
                        </x-inputs.Multi-Vertical.select>

                        <x-Date.picker-h name="start_date" dateId="start_date" label="Start Date" isRequired="true"
                            description="Select Offer Start Date" />

                        <x-Date.picker-h name="end_date" dateId="end_date" label="End Date" isRequired="true"
                            description="Select Offer End Date" />

                        <x-inputs.h-multi-select-search name="stocks[]" label="Offer Items" view="w" isRequired="true"
                            placeholder="Select Product to add" description="Search Products By Name And Sku To Add"
                            ajaxRoute="{{ route('dashboard.products.ajax.nameSearch') }}" selectId="stocks"
                            size="col-md-6 col-12" onchange="changeStocks(this,'items')" />
                        <x-Image.single description="Add Offer Image" />
                    </div>
                </div>
            </div>
            <!--  Divider  -->
            <div class="divider">
                <div class="divider-text text-muted">{{ translate('Products Offer') }}</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="products-items">

                    </div>
                </div>
            </div>

            <!--  End Divider  -->

            <div id="gift-container" style="display: none;">
                <!--  Divider  -->
                <div class="divider">
                    <div class="divider-text text-muted">{{ translate('Products Gifts') }}</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="gift-selector">
                            <x-inputs.h-multi-select-search name="stockGifts[]" label="Offer Gift" view="h"
                                placeholder="Select Product to add" description="Search Products By Name And Sku To Add"
                                ajaxRoute="{{ route('dashboard.products.ajax.nameSearch') }}" selectId="gifts"
                                onchange="changeStocks(this,'gifts')" />
                        </div>
                        <div class="products-gifts">

                        </div>
                    </div>
                </div>

                <!--  End Divider  -->
            </div>
            <div class="col-12">
                <x-Button.submit type="button" onclick="validateInputs()" />
                <x-Button.rest />
            </div>

        </form>
    </x-Content.normal>
@endsection
@section('modal')
    <x-Files.single inputFormId="imageId" showTagId="showImage" />
@endsection
@push('layout-scripts')
    <script>
        let stocks = {
            gifts: {},
            items: {}
        };

        $("#type").change(function(e) {
            e.preventDefault();
            var value = $(this).val();
            $('#value').val('0');
            if (value == 'gift') {
                $('#value').attr('disabled', 'disabled');
                $('#gift-container').show();
                $('#gifts').select2({
                    ajax: {
                        url: '{{ route('dashboard.products.ajax.nameSearch') }}',
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
            } else {
                var input = document.getElementById('value');
                if (value == 'percentage') {
                    input.placeholder = '{{ translate('Enter The Value Of The Offer') }} %'
                } else {
                    input.placeholder = '{{ translate('Enter The Value Of The Offer') }} '
                }
                $('#gift-container').hide();
                $('.products-gifts').html('');
                $("#value").removeAttr('disabled');
            }
        });

        function changeStocks(element, type) {
            let values = $(element).val();

            if (isEmpty(stocks[type])) {
                $.each(values, function(indexInArray, valueOfElement) {
                    var stock = JSON.parse(valueOfElement);
                    stocks[type][stock.id] = stock;
                    $(`.products-${type}`).append(productItems(stock, indexInArray, type));
                });
            } else {
                var addedStocks = Object.keys(stocks[type]);
                var newStocks = $.map(values, function(elementOrValue, indexOrKey) {
                    return `${JSON.parse(elementOrValue).id}`;
                });

                var stockToAdd = arrayDiff(newStocks, addedStocks);

                var stockToDelete = arrayDiff(addedStocks, newStocks);

                $.each(values, function(indexInArray, valueOfElement) {
                    var stock = JSON.parse(valueOfElement);

                    if (stockToAdd.includes(`${stock.id}`)) {
                        stocks[type][`${stock.id}`] = stock;
                        $(`.products-${type}`).append(productItems(stock, indexInArray, type));
                    }


                });

                $.each(stockToDelete, function(indexInArray, valueOfElement) {
                    $(`#product-${type}-${valueOfElement}`).remove();
                    delete stocks[type][valueOfElement];
                });
            }
        }


        function productItems(stock, index, type) {
            return `
                <div class="row offer-${type}" id="product-${type}-${stock.id}" index="${index}">
                    <x-inputs.Multi-Vertical.input
                    description="Stock Information"
                        value="{{ translate('SKU') }}: ${stock.sku} , {{ translate('Seller') }} : ${stock.seller.user.name}"
                        label="name"
                        placeholder="Offer Name"  disabled size="col-6" />
                    <input type="hidden" value="${stock.id}" name="${type}[${index}][stock_id]" />
                    <x-inputs.Multi-Vertical.input
                    isRequired="true"
                    description="Enter Stock Quantity" value="1" label="Quantity" name="${type}[${index}][quantity]"
                        placeholder="Offer Name"  onkeypress="return isNumberKey(event)"
                        size="col-6" data-maxQuantity="${stock.qty}" data-productName="{{ translate('SKU') }}: ${stock.sku} , {{ translate('Seller') }} : ${stock.seller.user.name}" />
                </div>
            `
        }
    </script>
    <script>
        function validateInputs() {
            var form = $('#createForm')[0];
            var rules = {
                _token: Joi.string().required(),

                name: Joi.string().required().messages({
                    '*': '{{ translate('Name is required') }}',
                }),

                name_ar: Joi.string().required().messages({
                    '*': '{{ translate('Name in arabic is required') }}',
                }),
                imageId: Joi.string().required().messages({
                    '*': '{{ translate('Image is required') }}',
                }),
                type: Joi.string().required().messages({
                    '*': '{{ translate('Offer Type is required') }}',
                }),

                value: Joi.number().when('type', {
                    is: 'gift',
                    then: Joi.number().valid(0, "").messages({
                        '*': '{{ translate('value not important') }}'
                    }),
                    otherwise: Joi.number().when(Joi.ref('type'), {
                        is: 'percentage',
                        then: Joi.number().max(100).min(1).messages({
                            '*': '{{ translate('Discount value must be between 1 and 100') }}'
                        }),
                        otherwise: Joi.number().min(1).messages({
                            '*': '{{ translate('Discount value must grater than or equal 0 and less than price') }}'
                        }),
                    }),
                }),
                start_date: Joi.date().allow(null, ''),
                end_date: Joi.date().when(Joi.ref('start_date'), {
                    is: '',
                    then: Joi.allow(null, ''),
                    otherwise: Joi.required().messages({
                        '*': '{{ translate('You must add end date') }}'
                    }),
                })
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());

            delete formDataObject['stocks[]'];
            delete formDataObject['stockGifts[]'];

            var itemsCount = false;
            var giftsCount = false;

            for (const key in formDataObject) {
                if (key.startsWith('items')) {
                    itemsCount = true;
                } else if (key.startsWith('gifts')) {
                    giftsCount = true;
                }

                if (key.startsWith('items') || key.startsWith('gifts')) {
                    switch (true) {
                        case key.includes('stock_id'):
                            rules[key] = Joi.string().required().messages({
                                '*': '{{ translate('Product Stock is required') }}'
                            });
                            break;
                        case key.includes('quantity'):
                            rules[key] = Joi.number().min(1).max($(`[name="${key}"]`).data('maxquantity')).required()
                                .messages({
                                    '*': '{{ translate('Max Quantity is') }}' + ' ' + $(`[name="${key}"]`).data(
                                        'maxquantity') + ' ' + '{{ translate('for product') }}' + ' ' + $(
                                        `[name="${key}"]`).data('productname')
                                });
                            break;
                    }
                }
            }
            if (!itemsCount) {
                rules['items'] = Joi.required().messages({
                    '*': '{{ translate('Please add some items') }}'
                });
            }
            if (!giftsCount && $('#type').val() == 'gift') {
                rules['gifts'] = Joi.required().messages({
                    '*': '{{ translate('Please add some gifts') }}'
                });
            }


            var formDataObject = Object.fromEntries(
                Object.entries(formDataObject).map(([key, value]) => [key, typeof value === 'string' ? value.trim() :
                    value
                ])
            );
            const schema = Joi.object(rules);


            const result = schema.validate(formDataObject);
            if (result.error) {
                errorToast(result.error.message);
                var targetElement = $(`[name="${result.error.details[0].context.label}"]`);
                if (!result.error.details[0].context.label.includes('imageId') && targetElement) {
                    $('html, body').animate({
                        scrollTop: targetElement.height(),
                        behavior: 'smooth'
                    }, 1500);

                    $('html, body').promise().done(function() {
                        targetElement.focus();
                    });
                }

            } else {
                $(form).submit();
            }
        }
    </script>
@endpush
