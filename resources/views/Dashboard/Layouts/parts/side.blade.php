<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <h2 class="brand-text">{{ translate('Absher') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-white toggle-icon font-medium-4" data-feather="x-circle"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-white" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <x-side.naveItem name="Trips" data_fether="layers">
                <x-side.menuContent name="All Trips"
                    routeName="index" />
                <x-side.menuContent name="Add New Trip"
                    routeName="add" />
            </x-side.naveItem>
            <x-side.naveItem name="Buses" data_fether="layers">
                <x-side.menuContent name="All Buses"
                    routeName="dashboard" />

                <x-side.menuContent name="Add New Bus"
                    routeName="dashboard" />
            </x-side.naveItem>
            <x-side.naveItem name="Subscribtions" data_fether="layers">
                <x-side.menuContent name="Add New Subscribtion"
                    routeName="dashboard" />
                <x-side.menuContent name="All Subscribtions"
                    routeName="dashboard" />
            </x-side.naveItem>
        </ul>
    </div>
</div>