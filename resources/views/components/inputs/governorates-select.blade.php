@props([
'typeValue' => '',
'description' => false,
'label'=>'',
'namefor'=>'',
'id'=>'',
])

@use('App\Enums\Governorates')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder ">{{ translate($label) }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="{{$namefor}}" id="{{$id}}">
                    <option value="" disabled selected>{{ translate('Select Governorates') }}</option>
                    @foreach (Governorates::cases() as $governorate)
                    <option class="form-control" @selected($governorate->value == $typeValue)
                        value="{{($governorate->value) }}">{{ translate($governorate->name) }}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>
</div>