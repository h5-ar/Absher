<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <!-- bookmark-wrapper div -->
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <!-- dropdown-language li-->
            <li id="switch-lang" title="{{ translate('Language', 'descriptions') }}">
                <a class="fs-4">
                    {{ translate('EN') }}
                </a>
            </li>
            <li class="nav-item d-none d-lg-block" title="{{ translate('Theme', 'descriptions') }}"><a
                    class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            {{-- <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"
                        data-feather="search"></i></a>
                <div class="search-input">
                    <div class="search-input-icon"><i data-feather="search"></i></div>
                    <input class="form-control input" type="text" placeholder="search..." tabindex="-1"
                        data-search="search">
                    <div class="search-input-close"><i data-feather="x"></i></div>
                    <ul class="search-list search-list-main"></ul>
                </div>
            </li> --}}
            <!-- dropdown-cart li-->
            <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#"
                    title="{{ translate('Notifications', 'descriptions') }}" data-bs-toggle="dropdown"><i class="ficon"
                        data-feather="bell"></i><span class="badge rounded-pill bg-danger badge-up"
                        id="notification-count">holle</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">{{ translate('Notifications') }}</h4>
                            <div class="badge rounded-pill badge-light-primary"> <span id="unread-notifications-count">
                                    holle
                                </span>
                                {{ translate('New') }}
                            </div>
                        </div>
                    </li>
                    {{-- @dd($notifications); --}}
                    <li class="scrollable-container media-list">
                        <div id="normal-notifications">

                            <a class="d-flex notification-item" data-href="#"
                                data-notificationId="" data-read="false"
                                onclick="markAsRead(this)">
                                <div class="list-item d-flex align-items-start">
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading  fw-bolder">

                                        </p>
                                        <small class="notification-text">

                                        </small>
                                    </div>
                                </div>
                            </a>

                            <div id="empty-normal-notifications" class="d-flex">
                                <div class="list-item d-flex align-items-start">
                                    <div class="list-item-body flex-grow-1">
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="list-item d-flex align-items-center">
                            <h6 class="fw-bolder me-auto mb-0">{{ translate('System Notifications') }}</h6>
                        <div class="form-check form-check-primary form-switch">
                            <input class="form-check-input" id="systemNotification" type="checkbox" checked>
                            <label class="form-check-label" for="systemNotification"></label>
                        </div>
    </div> --}}
    {{-- <div id="system-notifications">
                            @forelse ($systemNotifications as $notification)
                                <a class="d-flex notification-item"
                                    data-href="{{ $notification->data['redirectUrl'] }}" onclick="markAsRead(this)"
    data-notificationId="{{ $notification->id }}" data-read="false">
    <div class="list-item d-flex align-items-start">
        <div class="list-item-body flex-grow-1">
            <p class="media-heading fw-bolder">{{ $notification->data['title'] }}</p>
            <small class="notification-text">{{ $notification->data['body'] }}</small>
        </div>
    </div>
    </a>
    @empty
    <div id="empty-system-notifications" class="d-flex">
        <div class="list-item d-flex align-items-start">
            <div class="list-item-body flex-grow-1">
            </div>
        </div>
    </div>
    @endforelse
    </div> --}}
    </li>

    {{-- <li id="markAllAsReadBtn"
                        class="dropdown-menu-footer @if ($unreadNotificationsCount <= 0) hidden @endif"><a
                            onclick="markAllAsRead()" class="btn btn-primary w-100"
                            style="cursor: pointer">{{ translate('Read all notifications') }}</a>
    </li> --}}
    </ul>
    </li>
    <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
            id="dropdown-user" href="" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <div class="user-nav d-sm-flex d-none">
                <span class="user-name fw-bolder"></span>
                <span class="user-status"></span>
            </div><span class="avatar"><img class="round"
                    src="{{ asset(auth()->user()->attache?->upload?->url) }}" alt="avatar" height="40"
                    width="40"><span class="avatar-status-online"></span></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
            <a class="dropdown-item" href="{{ route('dashboard.profile.show') }}"><i class="me-50"
                    data-feather="user"></i> {{ translate('Profile') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('settings') }}"><i class="me-50"
                    data-feather="settings"></i>{{ translate('Settings') }}</a>
            <a class="dropdown-item" href="{{ route('logout') }}"><i class="me-50"
                    data-feather="power"></i>{{ translate('Logout') }}</a>
        </div>
    </li>
    </ul>
    </div>
</nav>
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img {{-- src="../../../app-assets/images/icons/xls.png" --}} alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing
                        Manager</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img {{-- src="../../../app-assets/images/icons/jpg.png" --}} alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img {{-- src="../../../app-assets/images/icons/pdf.png" --}} alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                        Marketing Manager</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img {{-- src="../../../app-assets/images/icons/doc.png" --}} alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                        Designer</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img {{-- src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" --}} alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img {{-- src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" --}} alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img {{-- src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" --}} alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing
                        Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img {{-- src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" --}} alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web
                        Designer</small>
                </div>
            </div>
        </a></li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between"><a
            class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="me-75"
                    data-feather="alert-circle"></span><span>No
                    results found.</span></div>
        </a></li>
</ul>

<script>
    function markAllAsRead() {
        var unreadNotificaitonCount = Number($('#unread-notifications-count').text())

        $('#unread-notifications-count').text(0)
        $.ajax({
            type: "PUT",
            url: "#",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var notificaitonCount = Number($('#notification-count').text());
                $('#notification-count').text(0)
                let html = `<div id="empty-normal-notifications" class="d-flex">
                                    <div class="list-item d-flex align-items-start">
                                        <div class="list-item-body flex-grow-1">
                                        </div>
                                    </div>
                                </div>`

                $("#normal-notifications").html(html);
                $("#system-notifications").html(html);
                $("#markAllAsReadBtn").addClass('hidden');
            }
        });
    }

    function markAsRead(elem) {

        window.location.href = $(elem).data('href');
        if ($(elem).data('read') == "true") {
            return
        }

        var unreadNotificaitonCount = Number($('#unread-notifications-count').text())
        notificationId = $(elem).data('notificationid');

        // $('#unread-notifications-count').text((unreadNotificaitonCount - 1) < 0 ? 0 : (unreadNotificaitonCount - 1))
        // var notificaitonCount = Number($('#notification-count').text());
        // $('#notification-count').text((notificaitonCount - 1) < 0 ? 0 : (notificaitonCount - 1))
        return; //no mark as read
        $.ajax({
            type: "PUT",
            url: "#",
            data: {
                notification_id: notificationId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var notificaitonCount = Number($('#notification-count').text());
                $('#notification-count').text((notificaitonCount - 1) < 0 ? 0 : (notificaitonCount - 1))
                $(elem).data('read', 'true');
                window.location.href = $(elem).data('href');
            }
        });
    }
</script>