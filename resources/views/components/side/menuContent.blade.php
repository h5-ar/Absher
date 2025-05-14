@use('Illuminate\Support\Facades\Route')
@props([
    'name' => 'No Name',
    'data_fether' => 'file-text',
    'data_feather' => 'circle',
    'routeName' => ''
])
    <li class="@if (Route::is($routeName)) active @endif">
        <a class="d-flex align-items-center" href="{{ route($routeName) }}"><i data-feather="{{ $data_feather }}"></i><span
                class="menu-item text-truncate"
                data-i18n="{{ str()->lower(str()->slug($name)) }}">{{ translate($name) }}</span></a>
    </li>
