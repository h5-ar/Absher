@props([
'typeValue' => '',
'description' => false,
])

@use('App\models\Company')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Company') }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>

            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="company" id="company">
                    <option value="" disabled selected>{{ translate('Select Company') }}</option>
                    @foreach (Company::all() as $companies)
                    <option class="form-control" @selected($companies->id == $typeValue)
                        value="{{($companies->id) }}">{{ translate($companies->name) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>