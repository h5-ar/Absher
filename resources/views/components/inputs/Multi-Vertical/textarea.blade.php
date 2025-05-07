@props([
    'label' => '',
    'placeholder' => '',
    'id'    => '',
    'name'  => ''
])

<div class="col-md-6 col-12">
    <div class="mb-3">
        <div class="form-floating" style="height: 150px">
            <textarea class="form-control h-100 rounded" style="margin-top: 5%;" placeholder="{{ translate($placeholder) }}"
                id="{{$id}}" name="{{$name}}"   {{ $attributes->merge([]) }}>{{ $slot }}</textarea>
            <label class="fs-5 fw-bolder" for="{{$id}}">{{ translate($label) }}</label>
        </div>
    </div>
</div>
