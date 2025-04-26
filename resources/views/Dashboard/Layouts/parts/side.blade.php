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
            <x-side.naveItem name="Trips" data_fether="map-pin">
                <x-side.menuContent name="All Trips"
                    routeName="trip.index" />
                <x-side.menuContent name="Add A Quick Trip"
                    routeName="add.quick" />
                <x-side.menuContent name="Add A Vehicle Trip"
                    routeName="add.vehicle" />
            </x-side.naveItem>
            <x-side.naveItem name="Buses" data_fether="truck">
                <x-side.menuContent name="All Buses"
                    routeName="bus.index" />

                <x-side.menuContent name="Add New Bus"
                    routeName="add.bus" />
            </x-side.naveItem>
            <x-side.naveItem name="Plans" data_fether="file-text">
                <x-side.menuContent name=" All Plans"
                    routeName="index.plan" />
                <x-side.menuContent name="Add New Plan"
                    routeName="add.plan" />

            </x-side.naveItem>

            <x-side.naveItem name="Reservations" data_fether="file-text">
                <x-side.menuContent name=" All Reservations"
                    routeName="index.reservation" />
                

            </x-side.naveItem>
        </ul>
    </div>
</div>