@props([
'typeValue' => '',
'description' => false,
])

@use('App\models\Bus')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Bus') }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="Bus" id="Bus">
                    <option value="" disabled selected>{{ translate('Select Bus') }}</option>
                    @foreach (Bus::all() as $buses)
                    <option class="form-control" @selected($buses->id == $typeValue)
                        value="{{($buses->id) }}">{{ translate($buses->id) }} {{ translate($buses->type) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>