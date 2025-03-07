<!DOCTYPE html>
<html class="loading  @if (Session::get('theme')) {{ Session::get('theme') }} @else semi-dark-layout @endif"
    lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>{{ translate('Login Page') }}</title>
    <link rel="apple-touch-icon" href=app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href=app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/plugins/extensions/ext-component-toastr.css') }}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                    
                        
                        <h2 class="brand-logo ms-1" style="color:rgb(225,127,38)">
                        <a class="brand-text ms-1" href="#"> Absher</a>
                        </h2>
                        
                    
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img
                                    class="img-fluid" src="{{ asset('app-assets/images/pages/login-v2.svg') }}"
                                    alt="Login V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1" style="direction: rtl">
                                    {{ translate('Welcome to Absher') }}! 👋
                                </h2>
                                <p class="card-text mb-2" style="direction: rtl">
                                    {{ translate('Please sign-in to your Company') }}
                                </p>
                                
                                <form class="auth-login-form mt-2" action="{{ route('login.submit') }}"
                                    method="post">
                                    @csrf
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="login-username">{{ translate('Username') }}</label>
                                        <input class="form-control @error('username') is-invalid @enderror"
                                            id="login-username" type="text" name="username"
                                            value="{{ old('username') }}"
                                            placeholder="{{ translate('Enter username') }}"
                                            aria-describedby="login-username" autofocus="" tabindex="1"
                                            required />
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label"
                                                for="login-password">{{ translate('Password') }}</label>
                                            {{-- <a
                                                href="auth-forgot-password-cover.html"><small>Forgot
                                                    Password?</small></a> --}}
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input
                                                class="form-control form-control-merge @error('password') is-invalid @enderror"
                                                id="login-password" type="password" value="{{ old('password') }}"
                                                name="password" placeholder="············"
                                                aria-describedby="login-password" tabindex="2" required /><span
                                                class="input-group-text cursor-pointer"><i data-feather="eye"
                                                    @error('password') style="color: rgb(234, 84, 85)" @enderror></i></span>
                                        </div>

                                    </div>
                                    {{-- <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember-me" type="checkbox"
                                                tabindex="3" />
                                            <label class="form-check-label"
                                                for="remember-me">{{ translate('Remember Me') }}</label>
                            </div>
                        </div> --}}
                        <button class="btn w-100" style="background:rgb(225,127,38);color:white"
                            tabindex="4">{{ translate('Sign in') }}</button>
                        </form>
                        
                    </div>
                </div>
                <!-- /Login-->
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- END: Content-->


    @include('Dashboard.Layouts.parts.bodyScripts')

    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->


    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/auth-login.js') }}"></script>
    <!-- END: Page JS-->

    <script>
        // Add a new entry to the history stack when the page loads
        window.onload = function() {
            history.pushState(null, null, window.location.href);
        };

        // Listen for the popstate event to handle when the user navigates back
        window.onpopstate = function(event) {
            // Replace the current URL in the history stack to prevent going back
            history.pushState(null, null, window.location.href);
        };
    </script>
</body>
<!-- END: Body-->

</html>