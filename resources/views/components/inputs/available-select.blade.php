@props([
'typeValue' => '',
'description' => false,
'label'=>'',
])

@use('App\Enums\Available')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate($label) }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="available" id="default-select">
                    @foreach (Available::cases() as $available)
                    <option class="form-control" @selected($available->value == $typeValue)
                        value="{{($available->value) }}">{{ translate($available->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>