@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')
@section('title')
    {{ translate('Edit Product') }}
@endsection

@section('content')
    @php
        $colorsValues =
            array_key_exists('colors', $product->attributes) && isset($product->attributes['colors'])
                ? $product->attributes['colors']
                : [];
        $sizesValues =
            array_key_exists('sizes', $product->attributes) && isset($product->attributes['sizes'])
                ? $product->attributes['sizes']
                : [];
        $fabricsValues =
            array_key_exists('fabrics', $product->attributes) && isset($product->attributes['fabrics'])
                ? $product->attributes['fabrics']
                : [];
    @endphp
    <x-Content.normal>
        <form class="form" method="POST" id="editForm" action="{{ route('dashboard.products.update', $product->id) }}">
            @csrf
            @method('PUT')
            @include('Dashboard.Admin.Product.sections.edit-product-details', [
                'brands' => $brands,
                'categories' => $categories,
                'tags' => $tags,
                'product' => $product,
            ])

            <!--  Divider  -->
            <div class="divider">
                <div class="divider-text text-muted">{{ translate('Product Options') }}</div>
            </div>
            <!--  End Divider  -->


            <!--  Product Options  -->
            <div class="row">
                <!--  Product Global Discount  -->
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-bolder">{{ translate('Product Variants') }} :</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <x-inputs.Multi-Vertical.multi-select lable="Colors" name="colors[]" label="Colors"
                                    description="Pick Product Colors" size="col-6" placeholder="Click to add color"
                                    selectId="colors">
                                    @foreach ($colors as $color)
                                        @if (in_array($color->value, $colorsValues))
                                            <x-inputs.option lable2="{{ $color->value }}" value="{{ $color->value }}"
                                                selected />
                                        @else
                                            <x-inputs.option lable2="{{ $color->value }}" value="{{ $color->value }}" />
                                        @endif
                                    @endforeach
                                </x-inputs.Multi-Vertical.multi-select>

                                <x-inputs.Multi-Vertical.multi-select lable="Attributes" name="attributes[]"
                                    label="Attributes" size="col-6" placeholder="Click to add attributes"
                                    description="Pick Product Attributes" selectId="attributes">
                                    <x-inputs.option lable="Size" value="size"
                                        isSelected="{{ (bool) count($sizesValues) }}" />
                                    <x-inputs.option lable="Fabric" value="fabric"
                                        isSelected="{{ (bool) count($fabricsValues) }}" />
                                </x-inputs.Multi-Vertical.multi-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Options  -->


            <div id="varinat-options">
                <!--  Divider  -->
                <div class="divider">
                    <div class="divider-text text-muted">{{ translate('Product Options') }}</div>
                </div>
                <!--  End Divider  -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bolder">{{ translate('Product Variants') }} :</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <x-inputs.Multi-Vertical.multi-select name="sizes[]" label="Sizes" size="col-12"
                                description="Pick Product Sizes" placeholder="Click to add size" selectId="sizes"
                                size="col-md-6 col-12">
                                @foreach ($sizes as $size)
                                    @if (in_array($size->value, $sizesValues))
                                        <x-inputs.option lable2="{{ $size->value }}" value="{{ $size->value }}"
                                            selected />
                                    @else
                                        <x-inputs.option lable2="{{ $size->value }}" value="{{ $size->value }}" />
                                    @endif
                                @endforeach
                            </x-inputs.Multi-Vertical.multi-select>

                            <x-inputs.Multi-Vertical.multi-select name="fabrics[]" label="Fabric" size="col-12"
                                description="Pick Product Fabrics" placeholder="Click to add fabric" selectId="fabrics"
                                size="col-md-6 col-12">
                                @foreach ($fabrics as $fabric)
                                    @if (in_array($fabric->value, $fabricsValues))
                                        <x-inputs.option lable2="{{ $fabric->value }}" value="{{ $fabric->value }}"
                                            selected />
                                    @else
                                        <x-inputs.option lable2="{{ $fabric->value }}" value="{{ $fabric->value }}" />
                                    @endif
                                @endforeach
                            </x-inputs.Multi-Vertical.multi-select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="product-stocks">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bolder">{{ translate('Product Variants') }} :</h4>
                    </div>

                    <div class="card-body" id="product-stocks-body">

                    </div>
                </div>
            </div>

            <div class="col-12">
                <x-Button.submit type="button" onclick="validateInputs()" />
            </div>

        </form>
        <x-Files.multiple repeater="true" repeaterName="Variants" />
        <x-Files.single inputFormId="imageId" showTagId="showImage" />

    </x-Content.normal>
@endsection

@push('layout-scripts')
    <script>
        function updateDiscountPlaceholder(elem, id) {
            var input = document.getElementById(id);
            if ($(elem).val() == 'percentage') {
                input.placeholder = '{{ translate('Enter Discount Value') }} %'
            } else {
                input.placeholder = '{{ translate('Enter Discount Value') }} '
            }
        }

        var data = @json($colors);

        data.forEach(function(color, index) {
            data[index] = {
                id: color.value,
                text: `${color.value}`,
                html: `${color.value}<div class="rounded rounded-2 text-center w-50" style="height:5px;margin-left:25%;background:#${color.value};color:white"></div>`,
            }
        });
        $('#colors').select2({
            data: data,
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return data.html;
            },
            templateSelection: function(data) {
                return data.text;
            }
        })

        const sellers = @json($sellers);
        const stocks = @json($product->stocks);
        let productStocks = {};
        $.each(stocks, function(key, stock) {
            var attr = Object.values(stock.variant).join('-');
            if (!productStocks.hasOwnProperty(attr)) {
                productStocks[attr] = [];
            }
            productStocks[attr].push(stock);

        });


        function initGenerateVariants() {
            var colors = @json($colorsValues);
            var sizes = @json($sizesValues);
            var fabrics = @json($fabricsValues);
            var variants = '';


            if (typeof(colors) == 'array') {

                colors = colors.filter((item) => item != null || item != undefined || item != '');
            } else {
                colors = Object.values(colors)
            }

            if (typeof(sizes) == 'array') {

                sizes = sizes.filter((item) => item != null || item != undefined || item != '');
            } else {
                sizes = Object.values(sizes)
            }

            if (typeof(fabrics) == 'array') {

                fabrics = fabrics.filter((item) => item != null || item != undefined || item != '');
            } else {
                fabrics = Object.values(fabrics)
            }

            var variantsArray = {
                color: colors,
                size: sizes,
                fabric: fabrics,
            };
            var result = generateCombinations(colors, sizes, fabrics);

            $('#product-stocks-body [data-delete="true"]').remove();

            const additionalKeys = arrayDiff([...Object.keys(productStocks)], [...result]);

            result = [...additionalKeys, ...result]

            $.each(result, function(index, variant) {

                if (productStocks[variant]) {
                    var images = productStocks[variant][0].images;
                    var sku = productStocks[variant][0].sku;
                    sku = sku.split('-')[0];
                    sku = productStocks[variant][0].sku.split('-').slice(1).join('-');
                    var price = productStocks[variant][0].price;
                    var sellers = productStocks[variant];
                    var discountType = productStocks[variant][0]?.discount_type;
                    var discountValue = productStocks[variant][0]?.discount_value;
                    variants = varinat(variant, index, makeJsonVariant(variantsArray, variant), 'false', images,
                        sku,
                        price, discountType, discountValue)
                    $('#product-stocks-body').append(variants);
                    $.each(sellers, function(indexInArray, seller) {

                        addSeller(index, variant, seller);
                    });
                }
            });

            $.each($('#product-stocks-body .select2'), function(indexInArray, select) {
                $(select).select2();
            });

        }

        $(function() {
            @if (count($fabricsValues) == 0)
                $('#row_fabrics').hide();
            @endif

            @if (count($sizesValues) == 0)
                $('#row_sizes').hide();
            @endif

            @if (count($fabricsValues) == 0 && count($sizesValues) == 0)
                $('#varinat-options').hide();
            @endif

            @if ($product->recoverable)
                $('#recovery_duration').removeAttr('disabled');
            @endif
            initGenerateVariants()
        });

        /*
            to generate json for attribuites selected for each variant genrated to save it as attibutes array in backend
        */
        function makeJsonVariant(arrays, value) {
            var result = {
                color: '',
                size: '',
                fabric: '',
            };
            var variants = value.split('-');

            $.each(arrays, function(key, array) {
                $.each(variants, function(index, variantValue) {
                    if (array.indexOf(variantValue) != -1) {
                        result[key] = variantValue;
                    }
                });
            });

            return result;
        }

        function generateVariants() {
            var colors = $('#colors').val();
            var sizes = $('#sizes').val();
            var fabrics = $('#fabrics').val();

            if (typeof(colors) == 'array') {

                colors = colors.filter((item) => item != null || item != undefined || item != '');
            } else {
                colors = Object.values(colors)
            }

            if (typeof(sizes) == 'array') {

                sizes = sizes.filter((item) => item != null || item != undefined || item != '');
            } else {
                sizes = Object.values(sizes)
            }

            if (typeof(fabrics) == 'array') {

                fabrics = fabrics.filter((item) => item != null || item != undefined || item != '');
            } else {
                fabrics = Object.values(fabrics)
            }

            var variants = '';
            var variantsArray = {
                color: colors,
                size: sizes,
                fabric: fabrics,
            };

            const result = generateCombinations(colors, sizes, fabrics);
            let toKeep = [];
            var indexes = 0;
            $.each($('#product-stocks-body [data-delete="false"] .card-title'), function(indexInArray, valueOfElement) {
                toKeep.push(valueOfElement.outerText);
                indexes = indexInArray;
            });
            $.each(result, function(index, variant) {
                if (toKeep.indexOf(variant) == -1) {
                    indexes = indexes + 1;
                    variants += varinat(variant, indexes, makeJsonVariant(variantsArray, variant), 'true');
                }
            });

            // delete only not changed variants
            $('#product-stocks-body [data-delete="true"]').remove();
            $('#product-stocks-body').append(variants);
            $.each($('#product-stocks-body .select2'), function(indexInArray, select) {
                $(select).select2();
            });
        }

        $('#unit').keyup(function(e) {
            e.preventDefault();
            if (!validateWeightInput(e.target.value)) {
                $(this).addClass('is-invalid');
                return;
            }
            $(this).removeClass('is-invalid');
        });

        function generateCombinations(...arrays) {
            if (arrays.length === 0) return [];
            const result = arrays.reduce((accumulator, currentArray) => {
                if (accumulator.length === 0) return currentArray.map(item => [item]);
                const temp = [];

                accumulator.forEach((accItem) => {
                    currentArray.forEach((currItem) => {
                        temp.push([...accItem, currItem]);
                    });
                });
                if (temp.length == 0) {
                    return accumulator;
                } else {
                    return temp;
                }
            }, []);
            return result.map(combination => combination.join('-'));
        }


        $('#colors ,#sizes , #fabrics').change(function(e) {
            e.preventDefault();

            generateVariants();
        });

        $('#attributes').change(function(e) {
            e.preventDefault();
            var attributes = $('#attributes').val();

            var size = attributes.indexOf('size');

            var fabric = attributes.indexOf('fabric');

            if (size !== -1) {
                $('#varinat-options').show('fast');
                $('#row_sizes').show(400);
            } else {
                $('#sizes').val([]);
                $('#sizes').select2();
                $('#row_sizes').hide(300);
                generateVariants();
            }

            if (fabric !== -1) {
                $('#varinat-options').show('fast');
                $('#row_fabrics').show(400);
            } else {
                $('#fabrics').val([]);
                $('#fabrics').select2();
                $('#row_fabrics').hide(300);
                generateVariants();
            }

            if (attributes.length == 0) {
                $('#varinat-options').hide(500);
            }

        });


        function varinat(title, index, variantObject, toDelete, images = null, sku = null, price = null, discountType = '',
            discountValue = '') {

            let imagesLength = 0;
            const imageId = generateId();
            if (images != null) {
                images = JSON.parse(images)
                imagesLength = images.length;
                images = JSON.stringify(images)
            }
            if (sku === null) {
                sku = title;
            }
            if (price == null) {
                price = 0
            }
            if (discountValue == '' || discountValue == null) {
                discountValue = 0;
            }

            if (discountType == 'percentage') {
                return `<x-Product.variant
                    attributesName="${title}"
                    index="${index}"
                    imageId="${imageId}"
                    dataDelete="${toDelete}"
                    sku="${sku}"
                    price="${price}"
                    discountType="percentage"
                    discountValue="${discountValue}"
                    imagesLength="${imagesLength}"
                />`;
            } else {
                return `<x-Product.variant
                    attributesName="${title}"
                    index="${index}"
                    imageId="${imageId}"
                    dataDelete="${toDelete}"
                    sku="${sku}"
                    price="${price}"
                    discountType="discount"
                    discountValue="${discountValue}"
                    imagesLength="${imagesLength}"
                />`;
            }
        }

        function addSeller(variantIndex, variantId, sellerData = null) {

            $(`#${variantId} .divider`).show();

            $(`#${variantId}-sellers`).append(seller(variantIndex, variantId, sellerData));
            var sellerIndex = $(`#${variantId} #${variantId}-sellers`).data('sellers');
            $(`[name="variants[${variantIndex}][sellers][${sellerIndex}][seller_id]"]`).select2();
            $(`[name="variants[${variantIndex}][sellers][${sellerIndex}][discount_type]"]`).select2();
            $(`#${variantId} hr`).show();


        }

        function seller(variantIndex, varinatId, sellerData = null) {
            var sellerIndex = $($(`#${varinatId} #${varinatId}-sellers`)).data('sellers') + 1;
            $($(`#${varinatId} #${varinatId}-sellers`)).data('sellers', sellerIndex);
            let options = '';
            var selects = $(`#${varinatId} select`);
            var selectsValues = [];
            $.each(selects, function(indexInArray, valueOfElement) {
                selectsValues.push($(valueOfElement).val());
            });
            $.each(sellers, function(indexInArray, seller) {
                if (selectsValues.indexOf(`${seller.id}`) == -1) {
                    var name = ''
                    if (seller.user.last_name) {
                        name = seller.user.name + ' ' + seller.user.last_name;
                    } else {
                        name = seller.user.name;
                    }
                    if (sellerData !== null) {
                        var isSelected = seller.id === sellerData.seller_id;
                        if (isSelected) {
                            options +=
                                `<x-inputs.option lable2="${name}" value="${seller.id}" isSelected="true" />`;
                        } else {
                            options +=
                                `<x-inputs.option lable2="${name}" value="${seller.id}" />`;
                        }

                    } else {
                        options += `<x-inputs.option lable2="${name}" value="${seller.id}"  />`
                    }
                }
            });
            if (options == '') {
                errorToast('{{ translate('No sellers to add') }}')
                return;
            }

            var qty = 0;
            var price = 0;
            var stockId = '';
            var discountValue = 0;
            var discountType = 'discount';
            if (sellerData !== null) {
                qty = sellerData.qty;
                price = sellerData.purchase_price;
                stockId = sellerData.id;
                // discountType = sellerData.discount_type;
                // discountValue = sellerData.discount_value;
            }

            return `
                    <div class="row" id="${generateId()}">
                        <x-inputs.Multi-Vertical.select selectId="${generateId()}" onchange="chenageSelectSeller('${varinatId}',this)" name="variants[${variantIndex}][sellers][${sellerIndex}][seller_id]" description="Select Seller"
                            lable="Seller" size="col-3" title="Select Seller">
                            ${options}
                        </x-inputs.Multi-Vertical.select>

                        <x-inputs.Multi-Vertical.input label="Quantity" name="variants[${variantIndex}][sellers][${sellerIndex}][qty]" description="Enter Quantity For Seller"
                            inputmode="numeric" size="col-3" value="${qty}"
                            onkeypress="return isNumberKey(event)" placeholder="Variant Price"
                            required />


                        <x-inputs.Multi-Vertical.input label="Purchase Price"
                            name="variants[${variantIndex}][sellers][${sellerIndex}][purchase_price]" inputmode="numeric" description="Enter Purchase Price From Seller"
                            size="col-3" value="${price}" onkeypress="return isNumberKey(event)"
                            placeholder="Purchase Price" required />


                        <input type="hidden" name="variants[${variantIndex}][sellers][${sellerIndex}][stock_id]" value="${stockId}" />


                        <div class="col-3" style="margin-top: 1.8rem;">
                            <button type="button" onclick="remove($(this).parent().parent())" class="btn btn-danger"> {{ translate('Delete') }} </button>
                        </div>
                        <hr class="my-3" style="width:80%;height:2px;" />
                    </div>
            `;


        }

        function chenageSelectSeller(sellerContainerId, element) {
            var selectsHtml = $(`#${sellerContainerId} select`);
            selects = [];
            $.each(selectsHtml, function(indexInArray, htmlSelect) {
                if (!$(htmlSelect).attr('id').includes('discount_type') && !$(htmlSelect).attr('id').includes(
                        'discount_value')) {
                    selects.push(htmlSelect);
                }
            });
            var sellersValues = [];
            $.each(selects, function(indexInArray, selectElement) {
                if (selectElement.id != element.id) {
                    sellersValues.push($(selectElement).val());
                }
            });
            if (sellersValues.indexOf($(element).val()) != -1) {
                $(`#${element.id}`).val('');
                $(`#${element.id}`).select2();
                errorToast('{{ translate('Invalid Select') }}', '{{ translate('This seller has been selected') }}')
            } else {
                sellersValues.push($(element).val());
            }

            //rest select options to delete selected values
            $.each(selects, function(index, select) {
                var options = $(`#${select.id} option`);
                $.each(options, function(indexInArray, option) {
                    if ($(select).val() != $(option).attr('value') && sellersValues.indexOf($(option).attr(
                            'value')) != -1) {
                        $(option).remove();
                    }
                });
                $.each(sellers, function(indexInArray, seller) {
                    var added = false;
                    if (sellersValues.indexOf(`${seller.id}`) == -1) {
                        var elements = '';
                        $.each(options, function(indexInArray, option) {
                            if ($(option).attr('value') == seller.id) {
                                added = true;
                            }
                        });
                        if (!added) {
                            var name = ''
                            if (seller.user.last_name) {
                                name = seller.user.name + ' ' + seller.user.last_name;
                            } else {
                                name = seller.user.name;
                            }
                            elements += `<x-inputs.option lable2="${name}" value="${seller.id}" />`

                            $(select).append(elements);
                        }
                    }

                });
            });
        }

        $('#recoverable').change(function(e) {
            e.preventDefault();
            if ($('#recoverable:checked').length != 0) {
                $('#recovery_duration').removeAttr('disabled');
            } else {
                $('#recovery_duration').attr('disabled', 'disabled');
                $('#recovery_duration').val('');
            }
        });
    </script>

    <script>
        function validateInputs() {
            var form = $('#editForm')[0];

            var rules = {
                _token: Joi.string().required(),
                _method: Joi.string().required(),
                name: Joi.string().required().messages({
                    'string.base': '{{ translate('Name should be a string') }}',
                    'any.required': '{{ translate('Name is required') }}',
                }),

                name_ar: Joi.string().required().messages({
                    'string.base': '{{ translate('Name in arabic should be a string') }}',
                    'any.required': '{{ translate('Name in arabic is required') }}',
                }),

                sub_category_id: Joi.string().required().messages({
                    '*': '{{ translate('Category is required') }}',
                }),

                brand_id: Joi.string().required().messages({
                    '*': '{{ translate('Brand is required') }}',
                }),

                tags: Joi.array().items(Joi.string().required()).required().messages({
                    '*': '{{ translate('Tags is required') }}'
                }),
                unit: Joi.string().allow(null, '').messages({
                    '*': '{{ translate('Unit is required') }}'
                }),
                imageId: Joi.string().required().messages({
                    '*': '{{ translate('Image is required') }}',
                }),
                description: Joi.string().allow(null).allow(''),
                description_ar: Joi.string().allow(null).allow(''),
                min_quantity: Joi.number().min(1).required().messages({
                    '*': '{{ translate('Min quantity to show must be grater than 0') }}',
                }),
                max_quantity: Joi.number().min(Joi.ref('min_quantity')).required().messages({
                    '*': '{{ translate('Max quantity to show must be grater than or equal min quantity') }}'
                }),
                min_order: Joi.number().min(1).required().messages({
                    '*': '{{ translate('Min quantity to order product must be grater than 0') }}'
                }),
                max_order: Joi.number().min(Joi.ref('min_order')).required().messages({
                    '*': '{{ translate('Max quantity to order product must be grater than or equal min quantity') }}'
                }),
                recoverable: Joi.allow(null),
                recovery_duration: Joi.number().allow(null).when('recoverable', {
                    is: 'on',
                    then: Joi.number().min(1).messages({
                        '*': '{{ translate('Please add recovery duration grater than 0') }}'
                    }),
                }),
                recommended: Joi.allow(null),
                free_delivery: Joi.allow(null),
                flash_deal: Joi.allow(null),
                published: Joi.allow(null),
                colors: Joi.array(),
                sizes: Joi.array(),
                fabrics: Joi.array(),
            };

            var data = new FormData(form);
            var formDataObject = Object.fromEntries(data.entries());
            delete formDataObject['tags[]'];
            delete formDataObject['colors[]'];
            delete formDataObject['sizes[]'];
            delete formDataObject['fabrics[]'];
            delete formDataObject['attributes[]'];
            formDataObject['tags'] = $('#tags').val();
            formDataObject['colors'] = $('#colors').val();
            formDataObject['sizes'] = $('#sizes').val();
            formDataObject['fabrics'] = $('#fabrics').val();
            var variantsCount = 0;
            for (const key in formDataObject) {
                if (key.startsWith('variants')) {
                    switch (true) {
                        case key.includes('purchase_price'):
                            rules[key] = Joi.number().min(0).required().messages({
                                '*': '{{ translate('Purchase Price is required') }}'
                            });
                            break;
                        case key.includes('qty'):
                            rules[key] = Joi.number().min(0).required().messages({
                                '*': '{{ translate('Quantity is required') }}'
                            });
                            break;
                        case key.includes('seller_id'):
                            rules[key] = Joi.number().min(1).required().messages({
                                '*': '{{ translate('Seller is required for selected variant') }}'
                            });
                            variantsCount++;
                            break;
                        case key.includes('discount_type'):
                            rules[key] = Joi.allow(null);
                            break;
                        case key.includes('discount_value'):
                            rules[key] = Joi.allow(null).when(`${key.replace('discount_value','discount_type')}`, {
                                is: 'percentage',
                                then: Joi.number().max(100).min(1).messages({
                                    '*': '{{ translate('Discount value must be between 1 and 100') }}'
                                }),
                                otherwise: Joi.number().min(0).max(
                                    Joi.ref(key.replace('discount_value', 'price'))).messages({
                                    '*': '{{ translate('Discount value must grater than or equal 0 and less than price') }}'
                                }),
                            });
                            break;
                        case key.includes('price'):
                            rules[key] = Joi.number().greater(0).required().messages({
                                '*': '{{ translate('Variant Price must grater than 0') }}'
                            });
                            break;
                        case key.includes('images'):
                            rules[key] = Joi.string().required().messages({
                                '*': '{{ translate('Image is require for variant') }}'
                            });
                            break;
                        default:
                            rules[key] = Joi.required();
                    }
                }
            }
            if (variantsCount == 0) {
                rules['variants'] = Joi.number().min(1).required().messages({
                    '*': '{{ translate('Please add variants and sellers to this product') }}'
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
                if (!result.error.details[0].context.label.includes('imageId')) {
                    $('html, body').animate({
                        scrollTop: targetElement.height(),
                        behavior: 'smooth'
                    }, 1500);

                    $('html, body').promise().done(function() {
                        targetElement.focus();
                    });
                }
            } else {
                $(form).submit()
            }
        }
    </script>
@endpush
