@props([
    'qty' => '0',
    'price' => '0',
    'sellerIndex' => '',
    'variantIndex' => '',
    'options' => '',
])

@php
    $id = Str::uuid();
    $selectId = Str::uuid();
@endphp

<div class="row" id="{{ $id }}">
    <x-inputs.Multi-Vertical.select selectId="{{ $selectId }}" onchange="chenageSelectSeller('${varinatId}',this)"
        name="variants[{{ $variantIndex }}][sellers][{{ $sellerIndex }}][seller_id]" lable="Seller" size="col-3"
        title="Select Seller">
        {{ $options }}
    </x-inputs.Multi-Vertical.select>

    <x-inputs.Multi-Vertical.input label="Quantity"
        name="variants[{{ $variantIndex }}][sellers][{{ $sellerIndex }}][qty]" inputmode="numeric" size="col-3"
        value="{{ $qty }}" onkeypress="return isNumberKey(event)" placeholder="Variant Price" required />


    <x-inputs.Multi-Vertical.input label="Purchase Price"
        name="variants[{{ $variantIndex }}][sellers][{{ $sellerIndex }}][purchase_price]" inputmode="numeric"
        size="col-3" value="{{ $price }}" onkeypress="return isNumberKey(event)" placeholder="Purchase Price"
        required />

    <div class="col-3" style="margin-top: 1.8rem;">
        <button type="button" onclick="remove($(this).parent().parent())" class="btn btn-danger">
            {{ translate('Delete') }} </button>
    </div>
</div>

@push('layout-scripts')
    <script>
        $('#{{$selectId}}').select2();
    </script>
@endpush
