<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('super_admin.dashboard') }}">
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
            <x-side.naveItem name="Companies" data_fether="align-justify">
                <x-side.menuContent name="All Companies"
                    routeName="company.index" />
                <x-side.menuContent name="Add Company"
                    routeName="add.company" />
            </x-side.naveItem>

            <x-side.naveItem name="Users" data_fether="users">
                <x-side.naveItem name="Managers" data_fether="user-plus">
                    <x-side.menuContent name="All Managers"
                        routeName="manager.index" />

                    <x-side.menuContent name="Add Manager"
                        routeName="add.manager" />
                </x-side.naveItem>
                <x-side.naveItem name="User" data_fether="user">
                    <x-side.menuContent name="All User"
                        routeName="index.user" />

                    <x-side.menuContent name="Add User"
                        routeName="add.user" />
                </x-side.naveItem>
            </x-side.naveItem>

            <x-side.naveItem name="Trips" data_fether="map-pin">
                <x-side.menuContent name="All Trips"
                    routeName="index" />
                <x-side.menuContent name="Add A Quick Trip"
                    routeName="add.q" />
                <x-side.menuContent name="Add A Vehicle Trip"
                    routeName="add.v" />
            </x-side.naveItem>

            <x-side.naveItem name="Buses" data_fether="truck">
                <x-side.menuContent name="All Buses"
                    routeName="SAbus.index" />
                <x-side.menuContent name="Add New Bus"
                    routeName="SAadd.bus" />
            </x-side.naveItem>

            <x-side.naveItem name="Plans" data_fether="file-text">
                <x-side.menuContent name=" All Plans"
                    routeName="SAindex.plan" />
                <x-side.menuContent name="Add New Plan"
                    routeName="SAadd.plan" />
            </x-side.naveItem>

            <x-side.naveItem name="Reservation" data_fether="file-text">
                <x-side.menuContent name=" All Resrvations"
                    routeName="SAindex.reservation" />
                <x-side.menuContent name="Add New Resrvation"
                    routeName="SAadd.reservation" />
            </x-side.naveItem>

            <x-side.naveItem name="Subscription" data_fether="file-text">
                <x-side.menuContent name=" All Subscription"
                    routeName="SAindex.subscription" />
            </x-side.naveItem>

            <x-side.naveItem name="Shipping" data_fether="file-text">
                <x-side.menuContent name=" All Shipping"
                    routeName="SAindex.shipping" />
            </x-side.naveItem>
            <x-side.naveItem name="Notifications" data_fether="file-text">
                <x-side.menuContent name=" All Notifications"
                    routeName="SAnotifications.index" />
            </x-side.naveItem>
        </ul>
    </div>
</div>