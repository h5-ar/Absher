@props([
    'attributesName' => '',
    'sku' => '',
    'price' => '0',
    'dataDelete' => 'true',
    'index' => '',
    'imageId' => '',
    'discountType' => '',
    'discountValue' => '0',
    'imagesLength' => '0',
])


<div class="row border border-2 shadow-sm border-secondry rounded w-80 m-auto mb-1" id="{{ $attributesName }}"
    data-index="{{ $index }}" data-delete="{{ $dataDelete }}">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="rounded-circle border border-secondary mx-1" style="float:right">
                        <div class="rounded-circle" style="width:1rem;height:1rem;background-color:#${variantObject.color}">
                        </div>
                    </div>
                    <h5 class="card-title" style="float:left;">{{ $attributesName }}</h5>
                </div>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <a data-action="close" onclick="remove($('#{{ $attributesName }}'))">
                                <x-SVG.trash /> </a>
                            <a class="m-1" onclick="addSeller('{{ $index }}','{{ $attributesName }}')">
                                <x-SVG.plus />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <x-inputs.Multi-Vertical.input label="SKU" name="variants[{{ $index }}][sku]"
                        description="Product SKU" inputmode="numeric" size="col-4" value="{{ $sku }}"
                        placeholder="Variant SKU" required />

                    <x-inputs.Multi-Vertical.input label="Variant Price" name="variants[{{ $index }}][price]"
                        description="Stock Selling Price" inputmode="numeric" size="col-4"
                        value="{{ $price }}" onkeypress="return isNumberKey(event)" placeholder="Variant Price"
                        required />


                    <input type="hidden" name="variants[{{ $index }}][variant][color]"
                        value='${variantObject.color}' />
                    <input type="hidden" name="variants[{{ $index }}][variant][size]"
                        value='${variantObject.size}' />
                    <input type="hidden" name="variants[{{ $index }}][variant][fabric]"
                        value='${variantObject.fabric}' />

                    <div class="col-3 d-flex flex-column justify-content-center" style="padding-top:2rem">
                        <button type="button" data-bs-toggle="modal" href="#modalFilesMultiVariants" role="button"
                            class="fs-4 btn btn-sm btn btn-outline-primary" id="image-${imageId}"
                            data-inputId="${imageId}">
                            {{ translate('add Images') }}
                            <small>
                                <span style="color:#6F6F6F">Selected ({{ $imagesLength }})</span>
                            </small>
                        </button>
                        <input type="hidden" name="variants[{{ $index }}][images]" id="{{ $imageId }}"
                            autocomplete="off" value="${images}">
                    </div>

                    <x-inputs.Multi-Vertical.select name="variants[{{ $index }}][discount_type]"
                        description="Select Discount Type" selectId="variant-{{ $index }}-discount_type"
                        lable="Discount Type" size="col-6" title="Select Type"
                        onchange="updateDiscountPlaceholder(this,'variant-{{ $index }}-discount_value')">
                        <x-inputs.option lable="Percentage" value="percentage" isSelected="{{ $discountType }}" />
                        <x-inputs.option lable="Discount" value="discount" isSelected="{{ $discountType }}" />
                    </x-inputs.Multi-Vertical.select>

                    <x-inputs.Multi-Vertical.input label="Discount Value" size="col-6"
                        description="Enter Discount Value" inputId="variant-{{ $index }}-discount_value"
                        value="{{ $discountValue }}" name="variants[{{ $index }}][discount_value]"
                        inputmode="numeric" onkeypress="return isNumberKey(event)" placeholder="Discount Value" />
                </div>

                <div class="divider" style="display: none">
                    <div class="divider-text text-muted">{{ translate('Select Seller') }}</div>
                </div>
                <div class="row" id="{{ $attributesName }}-sellers" data-sellers="-1">

                </div>

                <hr style="display: none">
            </div>
        </div>
    </div>
</div>
