@props([
'name' => 'No Name',
'data_fether' => 'save',
'routeName' => '',
'useRole' => false,
])

<li class="nav-item @if (Route::is($routeName)) active @endif"><a class="d-flex align-items-center"
        href="{{ route($routeName) }}"><i data-feather="{{ $data_fether }}"></i><span class="menu-title text-truncate"
            data-i18n="{{ $name }}">{{ translate($name) }}</span></a>
</li>