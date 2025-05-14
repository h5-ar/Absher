@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\DiscountType')
@use('App\Enums\OrderStatus')
@use('App\Enums\Permission')

@section('title')
    {{ translate('User Details') }}
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
                            <x-Image.show url="{{ $user?->attache?->upload?->url }}" style="max-height: 240px;" />

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
                                <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                    class="btn btn-primary w-100 btn-next place-order">{{ translate('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- Checkout Place Order Right ends -->
                </div>
                <div class="d-flex flex-column">
                    @foreach ($user->orders as $order)
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items">
                            <div id="cardId" class="card ecommerce-card p-1">
                                <div class="item-img d-flex justify-content-start" style="padding-right: 35px">
                                    <x-Image.show classes="rounded rounded-2"
                                        style="box-shadow: 3px 6px 11px 0px  rgba(83, 80, 80, 0.952);max-height: 230px"
                                        url="{{ $order?->orderItem?->stock?->attache?->upload?->url }}" width="auto"
                                        height="auto" />
                                </div>

                                <div class="card-body" style="border-color: transparent;">
                                    <span class="fs-4 fw-bolder col-12">
                                        {{ translate('Order Number') . ' : ' }} <a
                                            href="{{ route('dashboard.orders.show', $order->order_number) }}">{{ $order->order_number }}</a>
                                    </span>
                                    <div class="d-flex flex-wrap">
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Total Price') . ' : ' }}
                                            <span class="fs-5 fw-bold"> {{ $order->total_price }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Items Quantity') . ' : ' }}
                                            <span class="fs-5 fw-bold">
                                                {{ $order->order_items_sum_product_quantity }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Tax') . ' : ' }} <span
                                                class="fs-5 fw-bold"> {{ $order->tax }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Shipping Cost') . ' : ' }}
                                            <span class="fs-5 fw-bold"> {{ $order->shipping_cost }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Status') . ' : ' }}
                                            @switch($order->status)
                                                @case(OrderStatus::PENDING)
                                                    <span class="text-warning" title="{{ translate('Pending', 'orders') }}">
                                                        <x-SVG.clock style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderStatus::ACCEPTED)
                                                    <span style="color: lightgreen" title="{{ translate('Accepted', 'orders') }}">
                                                        <x-SVG.check-circle style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderStatus::REJECTED)
                                                    <span class="text-danger" title="{{ translate('rejected', 'orders') }}">
                                                        <x-SVG.x-circle style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderStatus::REFUND)
                                                    <span class="text-primary" title="{{ translate('Refunded', 'orders') }}">
                                                        <x-SVG.refresh-cw style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderStatus::OUT_FOR_DELIVERY)
                                                    <span class="shaking" style="color: #7dbfbb"
                                                        title="{{ translate('Out For Delivery', 'orders') }}">
                                                        <x-SVG.truck style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderStatus::COMPLETED)
                                                    <span style="color: darkgreen" title="{{ translate('Completed', 'orders') }}">
                                                        <x-SVG.thumbs-up style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @default
                                            @endswitch
                                        </span>
                                        @php
                                            $address = (object) $order->address;
                                        @endphp
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Address') . ' : ' }} <span
                                                class="fs-5 fw-bold"> {{ $address?->city }} ,&nbsp;
                                                {{ $address?->line_one }}</span></span>

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
