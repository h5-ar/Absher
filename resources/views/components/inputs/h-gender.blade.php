@props([
'typeValue' => '',
'description' => false,
'namefor'=>'',
'id'=>'',
])

@use('App\Enums\BusType')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Type Bus') }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="{{$namefor}}" id="{{$id}}">
                    <option value="" disabled selected>{{$typeValue}}</option>
                    @foreach (BusType::cases() as $type)
                    <option class="form-control" @selected($type->value == $typeValue)
                        value="{{($type->value) }}">{{ translate($type->name) }}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>
</div>