@props([
    'value' => '',
    'lable' => '',
    'lable2' => '',
    'isSelected' => false,
    'translationFile' => 'translation',
])

<option class="form-control rounded" value="{{ $value }}" {{ $attributes->merge([]) }}
    @if ($isSelected === 'true' || $isSelected === '1' || $isSelected == $value) selected @endif>
    @if ($lable)
        {{ translate($lable,$translationFile) }}
    @else
        {{ $lable2 }}
    @endif
</option>
