@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\DiscountType')
@use('App\Enums\OrderStatus')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Profile Details') }}
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-ecommerce.css') }}">
    <style>
        body {
            padding-top: 1px;
        }
    </style>
@endpush
@section('content')
    <div class="app-content content ecommerce-application mt-1">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div id="place-order" class="list-view product-checkout">
                <!-- Checkout Place Order Right starts -->
                <div class="checkout-options">
                    <div class="card">
                        <div class="card-body">
                            <x-Image.show url="{{ $user?->attache?->upload?->url }}" />
                            <div class="coupons input-group input-group-merge d-flex justify-content-between">
                                <span class="fs-4 fw-bolder">{{ translate('Name') . ' : ' }}
                                    <span class="fs-4 fw-bolder">
                                        {{ $user->fullName === ' ' ? '---' : $user->fullName }}
                                    </span>

                                </span>
                            </div>
                            <hr />
                            <div class="price-details">
                                <h6 class="price-title">{{ translate('Details') }}</h6>
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Phone Number') }}</div>
                                        <div class="detail-amt discount-amt "> {{ $user->phone_number ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Email') }}</div>
                                        <div class="detail-amt">{{ $user->email ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Username') }}</div>
                                        <div class="detail-amt">{{ $user->username ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Birth Date') }}</div>
                                        <div class="detail-amt">{{ $user->birth_date ?? '---' }}</div>
                                    </li>
                                </ul>
                                <a href="{{ route('dashboard.staffs.edit', $user->id) }}"
                                    class="btn btn-primary w-100 btn-next place-order">{{ translate('Edit') }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Place Order Right ends -->
                </div>
                <div class="d-flex flex-column">
                    @foreach ($user->roles as $role)
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items d-flex justify-content-center">
                            <div id="cardId" class="card ecommerce-card p-1"
                                style="grid-template-columns: 1fr;width:70%">
                                <div class="card-body " style="border-color: transparent;">
                                    <div class="d-flex flex-wrap gap-3">
                                        <span class="fs-4 fw-bolder">
                                            {{ translate('Role Name') . ' : ' . $role->name }}
                                        </span>
                                        <span class="fs-4 fw-bolder ">{{ translate('Permissions Count') . ' : ' }}
                                            <span class="fs-5 fw-bold"> {{ $role->permissions_count }}</span>
                                        </span>
                                        <a id="permissions-{{ str($role->name)->replace(' ', '-') }}"
                                            onclick="togglePermissions(this)" class="fs-4 fw-bolder"
                                            style="color:var(--nav-item-sub-selected-background)">
                                            <x-SVG.eye style="height: 1.4rem;width:1.4rem" />
                                        </a>
                                        <div id="permissions-{{ str($role->name)->replace(' ', '-') }}-container"
                                            class="d-flex flex-wrap  justify-content-start d-none w-100">
                                            @foreach ($role->permissions as $permission)
                                                <div class="fs-5 col-3 nowrap mb-1  col-4">
                                                    {{ $permission->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Checkout Place Order Left ends -->


            </div>
        </div>
    </div>
@endsection
@push('layout-scripts')
    <script>
        function togglePermissions(e) {
            console.log(e.id);
            console.log(`${e.id}-container`);
            $(`#${e.id}-container`).toggleClass('d-none');
        }
    </script>
@endpush
