@props([
'typeValue' => '',
'description' => false,
])

@use('App\Enums\Days')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Day') }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="day" id="day">
                    @foreach (Days::cases() as $day)
                    
                    <option class="form-control" @selected($day->value == $typeValue)
                        value="{{($day->value) }}">{{ translate($day->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>