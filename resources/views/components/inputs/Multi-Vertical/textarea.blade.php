@props([
'label' => '',
'placeholder' => '',
'id' => '',
'name' => '',
'value'=>'',
])

<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate($label) }}</label>
            </div>
            <div class="col-10 col-sm-9">
                <textarea class="form-control" placeholder="{{ translate($placeholder) }}"
                    id="{{$id}}" name="{{$name}}" {{ $attributes->merge([]) }}>{{ $value }}</textarea>
            </div>
        </div>
    </div>
</div>
