@props([
    'genderValue' => '',
    'description' => false,
])

@use('App\Enums\UserGender')
<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired" for="Image">{{ translate('Gender') }}</label>
                @if ($description)
                    <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <select class="select2 form-select rounded" name="gender" id="default-select">
                    @foreach (UserGender::cases() as $gender)
                        <option class="form-control" @selected($gender->value == $genderValue)
                            value="{{ strtolower($gender->value) }}">{{ translate($gender->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
