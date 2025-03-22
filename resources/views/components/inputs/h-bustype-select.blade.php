@props([
'typeValue' => '',
'description' => false,
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
                <select class="select2 form-select rounded" name="bustype" id="bustype">
                <option value="" disabled selected>{{ translate('Select Type Of Bus') }}</option>
                    @foreach (BusType::cases() as $bustype)
                    <option class="form-control" @selected($bustype->value == $typeValue)
                        value="{{($bustype->value)}}">{{ translate($bustype->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>