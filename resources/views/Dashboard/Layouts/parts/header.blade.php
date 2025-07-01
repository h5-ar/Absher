<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <!-- bookmark-wrapper div -->
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="#">
                        <i class="ficon" data-feather="menu">

                        </i>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <!-- dropdown-language li-->
            <li id="switch-lang" title="{{ translate('Language', 'descriptions') }}">
                <a class="fs-4">
                    {{ translate('English') }}
                </a>
            </li>
            <li class="nav-item d-none d-lg-block" title="{{ translate('Theme', 'descriptions') }}">
                <a class="nav-link nav-link-style">
                    <i class="ficon" data-feather="moon">
                    </i>
                </a>
            </li>

            <!-- dropdown-cart li-->
            <li class="nav-item dropdown dropdown-notification me-25">
                <a class="nav-link" href="#" title="{{ translate('Notifications', 'descriptions') }}" data-bs-toggle="dropdown">
                    <i class="ficon" data-feather="bell"></i>
                    <span class="badge rounded-pill bg-danger badge-up" id="notification-count">
                        {{Auth::User()->unreadNotifications->count()}}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">
                                {{ translate('Notifications') }}
                            </h4>
                            <div class="badge rounded-pill badge-light-primary">
                                <span id="unread-notifications-count">
                                    {{Auth::User()->unreadNotifications->count()}}
                                </span>
                                {{ translate('New') }}
                            </div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        <div id="normal-notifications">
                            @foreach (Auth::User()->unreadNotifications as $notification)

                            <a class="d-flex notification-item"
                                data-notificationid="{{ $notification->id }}"
                                onclick="markAsRead(this)">
                                <div class="list-item d-flex align-items-start">
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading fw-bolder">
                                            {{ $notification->data['super_admin']['name']}}
                                        </p>
                                        <small class="notification-text">
                                            <div>{{ $notification->data['message'] }}</div>
                                            <div>{{ $notification->created_at }}</div>
                                        </small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @if(Auth::User()->unreadNotifications->count() == 0)
                            <div class="d-flex">
                                <div class="list-item d-flex align-items-start">
                                    <div class="list-item-body flex-grow-1">
                                        <p class="text-center">{{translate('No new notifications')}}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </li>
                    @if(Auth::User()->unreadNotifications->count() > 0)
                    <li id="markAllAsReadBtn">
                        <a onclick="markAllAsRead()" class="btn btn-primary w-100" style="cursor: pointer">
                            {{ translate('Read all notifications') }}
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder"></span>
                        <span class="user-status"></span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="https://ui-avatars.com/api/?name={{auth()->user()->username}}" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('dashboard.profile.show') }}"><i class="me-50"
                            data-feather="user"></i> {{ translate('Profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="me-50"
                            data-feather="power"></i>{{ translate('Logout') }}</a>
                </div>
            </li>
        </ul>
    </div>

</nav>



<script>
    function markAllAsRead() {
        $.ajax({
            type: "PUT",
            url: "{{ route('notifications.readAll') }}",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#notification-count').text(0);
                $('#unread-notifications-count').text(0);

                $("#normal-notifications").html(`
                    <div class="d-flex">
                        <div class="list-item d-flex align-items-start">
                            <div class="list-item-body flex-grow-1">
                                <p class="text-center">No new notifications</p>
                            </div>
                        </div>
                    </div>
                `);

                $("#markAllAsReadBtn").addClass('d-none');
            }

        });
    }

    function markAsRead(elem) {

        var notificationId = $(elem).data('notificationid');

        $.ajax({
            type: "PUT",
            url: "{{ route('notifications.read', '') }}/" + notificationId,
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var count = Number($('#notification-count').text());
                $('#notification-count').text(count - 1);

                var unreadCount = Number($('#unread-notifications-count').text());
                $('#unread-notifications-count').text(unreadCount - 1);

                $(elem).remove();

                if ($('.notification-item').length === 0) {
                    $("#normal-notifications").html(`
                        <div class="d-flex">
                            <div class="list-item d-flex align-items-start">
                                <div class="list-item-body flex-grow-1">
                                    <p class="text-center">No new notifications</p>
                                </div>
                            </div>
                        </div>
                    `);
                    $("#markAllAsReadBtn").addClass('d-none');
                }
            },

        });
    }
</script>