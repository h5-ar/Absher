<!DOCTYPE html>
<html class="loading @if (Session::get('theme')) {{ Session::get('theme') }} @else semi-dark-layout @endif"
    lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    {{-- <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities."> --}}
    {{-- <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app"> --}}
    <meta name="author" content="PIXINVENT">
    <title>@yield('title')</title>
    @include('Dashboard.Layouts.parts.headStyle')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
   
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">


    <!-- BEGIN: Header-->
    @include('Dashboard.Layouts.parts.header')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('Dashboard.Layouts.parts.side')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->


    @yield('modal')


    @yield('modalSecod')

    <div class="modal fade" id="upload" aria-hidden="true" aria-labelledby="uploadLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ translate('Upload') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="file-popup-uploader" class="filepond" multiple autocomplete="off"
                        name="image_uploader" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    @yield('show-image')
    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        {{-- <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy;
            2021<a class="ms-25" href="https://1.envato.market/pixinvent_portfolio"
            target="_blank">Pixinvent</a><span class="d-none d-sm-inline-block">, All rights
                Reserved</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i
                    data-feather="heart"></i></span></p> --}}
        {{-- </footer> --}}
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
        <!-- END: Footer-->

        <script type="module">
            import {
                initializeApp
            } from 'https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js'

            import {
                getMessaging,
                getToken,
                onMessage,
            } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-messaging.js";

            


            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
           

            function appendToNotificationsList(data, notification) {
                let html = '';

                html = `<a class="d-flex isRequired"
                data-notificationId="${data.notificationId}"
                data-href="${data.redirectUrl}"
                 onclick="markAsRead(this)">
                                <div class="list-item d-flex align-items-start">
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading fw-bolder">${notification.title}</p>
                                        <small class="notification-text"> ${notification.body}</small>
                                    </div>
                                </div>
                            </a>`;

                if (data.type === "system") {
                    $("#system-notifications").prepend(html);
                    $('#empty-system-notifications').addClass("d-none");
                } else {
                    $("#normal-notifications").prepend(html);
                    $('#empty-normal-notifications').addClass("d-none");
                }
                $("#markAllAsReadBtn").removeClass('hidden');
            }
        </script>

        @include('Dashboard.Layouts.parts.bodyScripts')


        {{-- script for file pond uploader --}}
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginImagePreview);


            function initializeFilePond(triggerElement) {
                // Get a reference to the file input element
                const inputElement = document.getElementById('file-popup-uploader');

                var trigegerId = $(triggerElement).attr('id');

                // Create a FilePond instance
                var pond = FilePond.create(inputElement, {
                    acceptedFileTypes: ['image/*'],
                    allowMultipel: true,
                    name: 'image_uploader',
                    server: {
                        url: '',
                        method: 'POST',
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        process: {
                            onload: (response) => {
                                var file = JSON.parse(response).data;
                                $('.no-result').addClass('d-none');
                                $('.no-result2').addClass('d-none');
                                var newElemnt = `<div class="card file-manager-item file" id="file-manager-item${file.id}"
                                                onclick="selectImage('customCheck${file.id}')">
                                                <div class="form-check">
                                                    <input type="radio" value="${file.id}"
                                                        onchange="changeSelect(this)" name="radioFile"
                                                        imageUrl="{{ asset('') }}${ file.url }" class="form-check-input"
                                                        id="customCheck${file.id}" autocomplete="off" />
                                                    <label class="form-check-label"
                                                        for="customCheck${file.id}"></label>
                                                </div>
                                                <div class="card-img-top file-logo-wrapper">
                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img src="{{ asset('') }}${ file.url }" alt="Image" height="100vh"
                                                            width="100%" />
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="content-wrapper">
                                                        <p class="card-text file-name mb-0">${file.name}</p>
                                                        <p class="card-text file-date">
                                                            {{ Carbon\Carbon::parse(now())->format('d F Y') }}</p>
                                                    </div>
                                                    <small
                                                        class="file-accessed text-muted">{{ Carbon\Carbon::parse(now())->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>`;

                                var repeaterElement = `<div class="card file-manager-item file"
                                                onclick="selectImage('customCheckReptear${file.id}')">
                                                <div class="form-check">
                                                    <input type="radio" value="${file.id}" name="radioFile"
                                                        onchange="changeSelectRepeater(this)"
                                                        imageUrl="{{ asset('') }}${ file.url }" class="form-check-input"
                                                        id="customCheckReptear${file.id}" autocomplete="off" />
                                                    <label class="form-check-label"
                                                        for="customCheckReptear${file.id}"></label>
                                                </div>
                                                <div class="card-img-top file-logo-wrapper">
                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img src="{{ asset('') }}${ file.url }" alt="Image" height="100vh"
                                                            width="100%" />
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="content-wrapper">
                                                        <p class="card-text file-name mb-0">${file.name}</p>
                                                        <p class="card-text file-date">
                                                            {{ Carbon\Carbon::parse(now())->format('d F Y') }}</p>
                                                    </div>
                                                    <small
                                                        class="file-accessed text-muted">{{ Carbon\Carbon::parse(now())->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>`;

                                var singleFileContainer = $("#view-container-single");
                                var repeaterFileContainer = $("#view-container-repeater");
                                if (singleFileContainer) {

                                    $("#view-container-single").prepend(newElemnt);
                                }

                                if (repeaterFileContainer) {
                                    $("#view-container-repeater").prepend(repeaterElement);
                                }
                            },
                        }
                    },
                });

                
            }


            $('#upload').on('hidden.bs.modal', function() {
                const filePond = FilePond.find(document.getElementById('file-popup-uploader'));
                if (filePond) {
                    filePond.destroy();
                }
            });

            $('#upload').on('shown.bs.modal', function(event) {
                initializeFilePond(event.relatedTarget);
            });
        </script>
        @stack('layout-scripts')
</body>
<!-- END: Body-->

</html>
