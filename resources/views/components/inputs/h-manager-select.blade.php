@props([
'typeValue' => '',
'description' => false,
])

@use('App\models\Manager')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Manager') }}</label>
                @if ($description)
                <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="manager" id="manager">
                    @foreach (Manager::all() as $managers)
                    <option class="form-control" @selected($managers->value == $typeValue)
                        value="{{($managers->id) }}">{{ translate($managers->first_name) }} {{ translate($managers->last_name) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>