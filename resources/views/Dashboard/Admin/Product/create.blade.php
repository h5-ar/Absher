@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')
@section('title')
    {{ translate('Create Product') }}
@endsection

@push('scripts')
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
@endpush

@push('styles')
    <style>
        #select2-colors-results::-webkit-scrollbar {
            width: 5px !important;
        }

        #select2-colors-results::-webkit-scrollbar-thumb {
            background-color: var(--nav-item-sub-selected-background) !important;
            width: 2px !important;
        }
    </style>
@endpush

@section('content')
    <x-Content.normal>
        <form id="createForm" class="form" method="POST" action="{{ route('dashboard.products.store') }}">
            @csrf

            @include('Dashboard.Admin.Product.sections.product-details', [
                'brands' => $brands,
                'categories' => $categories,
                'tags' => $tags,
            ])

            <!--  Divider  -->
            <div class="divider">
                <div class="divider-text text-muted">{{ translate('Product Options') }}</div>
            </div>
            <!--  End Divider  -->


            <!--  Product Options  -->
            <div class="row">
                <!--  Product Global Discount  -->
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-bolder">{{ translate('Product Discount') }} :</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <x-inputs.Multi-Vertical.select name="main_discount_type" selectId="main_discount_type"
                                        description="Select Discount Type" lable="Discount Type" size="col-12"
                                        title="Select Type">
                                        <x-inputs.option lable="Percentage" value="percentage" />
                                        <x-inputs.option lable="Discount" value="discount" selected />
                                    </x-inputs.Multi-Vertical.select>

                                    <x-inputs.Multi-Vertical.input label="Discount Value" size="col-12"
                                        description="Enter Discount Value" inputId="main_discount_value"
                                        name="main_discount_value" value="0" inputmode="numeric"
                                        onkeypress="return isNumberKey(event)" placeholder="Discount Value" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Product Global Discount  -->

                <!--  Product Global Discount  -->
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-bolder">{{ translate('Product Variants') }} :</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12" id="row_colors">
                                        <div class="mb-1">
                                            <label class="form-label fs-5 fw-bolder"
                                                for="colors">{{ translate('Colors') }}</label>
                                            <x-SVG.alert-circle description="Pick Product Colors" />
                                            <select class="select2 form-select rounded" multiple="multiple" id="colors"
                                                data-placeholder="Click to add color" name="colors[]">
                                                @foreach ($colors as $color)
                                                    {{-- <option class="form-control rounded" value="{{ $color->value }}">
                                                        {{ $color->value }}
                                                    </option> --}}
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <x-inputs.Multi-Vertical.multi-select lable="Attributes"
                                        description="Pick Product Attributes" name="attributes[]" label="Attributes"
                                        size="col-12" placeholder="Click to add attributes" selectId="attributes">
                                        <x-inputs.option lable="Size" value="size" />
                                        <x-inputs.option lable="Fabric" value="fabric" />
                                    </x-inputs.Multi-Vertical.multi-select>
                                </div>
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
                                    <x-inputs.option lable2="{{ $size->value }}" value="{{ $size->value }}" />
                                @endforeach
                            </x-inputs.Multi-Vertical.multi-select>

                            <x-inputs.Multi-Vertical.multi-select name="fabrics[]" label="Fabric" size="col-12"
                                description="Pick Product Fabrics" placeholder="Click to add fabric" selectId="fabrics"
                                size="col-md-6 col-12">
                                @foreach ($fabrics as $fabric)
                                    <x-inputs.option lable2="{{ $fabric->value }}" value="{{ $fabric->value }}" />
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
                <x-Button.rest />
            </div>

        </form>
        <x-Files.single inputFormId="imageId" showTagId="showImage" />

        <x-Files.multiple repeater="true" repeaterName="Variants" />
    </x-Content.normal>
@endsection

@push('layout-scripts')
    <script>
        $('#main_discount_type').change(function(e) {
            e.preventDefault();
            var input = document.getElementById('main_discount_value');
            if ($(this).val() == 'percentage') {
                input.placeholder = '{{ translate('Enter Discount Value') }} %'
            } else {
                input.placeholder = '{{ translate('Enter Discount Value') }} '
            }
        });
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


        $(function() {
            $('#row_sizes').hide();
            $('#row_fabrics').hide();
            $('#varinat-options').hide();

        });

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
            var variants = '';
            var variantsArray = {
                color: colors,
                size: sizes,
                fabric: fabrics,
            };
            const result = generateCombinations(colors, sizes, fabrics);

            $.each(result, function(index, variant) {
                variants += varinat(variant, index, makeJsonVariant(variantsArray, variant))
            });

            $('#product-stocks-body').html('');
            $('#product-stocks-body').append(variants);
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


        function varinat(title, index, variantObject) {
            const imageId = generateId();
            return `
                        <div class="row border border-2 shadow-sm border-secondry rounded w-80 m-auto mb-1"
                            id="${title}" data-index="${index}" >
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div>
                                            <div class="rounded-circle border border-secondary mx-1" style="float:right">
                                                <div class="rounded-circle" style="width:1rem;height:1rem;background-color:#${variantObject.color}">
                                                </div>
                                            </div>
                                            <h5 class="card-title" style="float:left;">${title}</h5>
                                        </div>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li>
                                                    <a data-action="close" onclick="remove($('#${title}'))">
                                                        <x-SVG.trash /> </a>
                                                    <a class="m-1" onclick="addSeller('${index}','${title}')" >
                                                        <x-SVG.plus />
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <x-inputs.Multi-Vertical.input label="SKU" name="variants[${index}][sku]" description="Product SKU"
                                                inputmode="numeric" size="col-4" value="${title}"
                                                placeholder="Variant SKU" required />

                                            <x-inputs.Multi-Vertical.input label="Variant Price" name="variants[${index}][price]" description="Stock Selling Price"
                                                inputmode="numeric" size="col-4" value="0"
                                                onkeypress="return isNumberKey(event)" placeholder="Variant Price"
                                                required />

                                            <input type="hidden" name="variants[${index}][variant][color]" value='${variantObject.color}' />
                                            <input type="hidden" name="variants[${index}][variant][size]" value='${variantObject.size}' />
                                            <input type="hidden" name="variants[${index}][variant][fabric]" value='${variantObject.fabric}' />

                                            <div class="col-3 d-flex flex-column justify-content-center" style="padding-top:2rem">
                                                <button type="button" data-bs-toggle="modal" href="#modalFilesMultiVariants" role="button"
                                                    class="fs-4 btn btn-sm btn btn-outline-primary"
                                                    id="image-${imageId}" data-inputId="${imageId}">
                                                    {{ translate('add Images') }}
                                                    <small>
                                                        <span style="color:#6F6F6F">Selected (0)</span>
                                                    </small>
                                                </button>
                                                <input type="hidden" name="variants[${index}][images]" id="${imageId}"
                                                        autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="divider" style="display: none">
                                            <div class="divider-text text-muted">{{ translate('Select Seller') }}</div>
                                        </div>
                                        <div class="row" id="${title}-sellers" data-sellers="-1" >

                                        </div>
                                        <hr style="display: none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
        }

        function addSeller(variantIndex, variantId) {
            $(`#${variantId} .divider`).show();

            $(`#${variantId}-sellers`).append(seller(variantIndex, variantId));
            var sellerIndex = $(`#${variantId} #${variantId}-sellers`).data('sellers');
            $(`[name="variants[${variantIndex}][sellers][${sellerIndex}][seller_id]"]`).select2();
            $(`#${variantId} hr`).show();


        }

        function seller(variantIndex, varinatId) {
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
                    options += `<x-inputs.option lable2="${name}" value="${seller.id}" />`
                }
            });
            if (options == '') {
                errorToast('{{ translate('No sellers to add') }}')
                return;
            }
            return `
                    <div class="row" id="${generateId()}">
                        <x-inputs.Multi-Vertical.select selectId="${generateId()}" onchange="chenageSelectSeller('${varinatId}',this)" name="variants[${variantIndex}][sellers][${sellerIndex}][seller_id]" description="Select Seller"
                            lable="Seller" size="col-3" title="Select Seller">
                            ${options}
                        </x-inputs.Multi-Vertical.select>

                        <x-inputs.Multi-Vertical.input label="Quantity" name="variants[${variantIndex}][sellers][${sellerIndex}][qty]"
                            inputmode="numeric" size="col-3" value="0" description="Enter Quantity For Seller"
                            onkeypress="return isNumberKey(event)" placeholder="Variant Price"
                            required />


                        <x-inputs.Multi-Vertical.input label="Purchase Price" description="Enter Purchase Price From Seller"
                            name="variants[${variantIndex}][sellers][${sellerIndex}][purchase_price]" inputmode="numeric"
                            size="col-3" value="0" onkeypress="return isNumberKey(event)"
                            placeholder="Purchase Price" required />

                        <div class="col-3" style="margin-top: 1.8rem;">
                            <button type="button" onclick="remove($(this).parent().parent())" class="btn btn-danger"> {{ translate('Delete') }} </button>
                        </div>
                    </div>
            `;
        }

        function chenageSelectSeller(sellerContainerId, element) {
            var selects = $(`#${sellerContainerId} select`);
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
            var form = $('#createForm')[0];
            var rules = {
                _token: Joi.string().required(),
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
                main_discount_type: Joi.string().allow(null),
                main_discount_value: Joi.number().when('main_discount_type', {
                    is: 'percentage',
                    then: Joi.number().max(100).min(1).messages({
                        '*': '{{ translate('Discount value must be between 1 and 100') }}'
                    }),
                    otherwise: Joi.number().min(0).messages({
                        '*': '{{ translate('Discount value must grater than or equal 0 and less than price') }}'
                    }),
                }),
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
