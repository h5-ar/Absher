@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\DiscountType')
@use('App\Enums\OrderItemStatus')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Order Detail') . ' #' . $order->order_number }}
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-ecommerce.css') }}">
    <style>
        .seller-details {
            padding-right: 3rem;
        }

        .seller-content {
            padding-right: 3rem;
        }

        @media screen and (max-width : 990px) {
            .seller-details {
                padding-right: 4rem;
                padding-top: .5rem;
                padding-bottom: .5rem;
            }

            .seller-content {
                padding-right: 1rem;
            }

        }

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
                            @if ($order?->user?->attache?->upload?->url)
                                <x-Image.show url="{{ $order?->user?->attache?->upload?->url }}"
                                    style="max-height: 240px;margin-bottom: 1rem;" />
                            @else
                                <x-Image.show url="assets/images/defualt-user.png"
                                    style="max-height: 240px;margin-bottom: 1rem;" />
                            @endif

                            <div class="coupons input-group input-group-merge d-flex justify-content-between">
                                <span class="fs-4 fw-bolder">{{ translate('Username') . ' : ' }}
                                    <span class="fs-4 fw-bolder">
                                        {{ $order->user?->fullName }}
                                    </span>
                                </span>
                                <a style="margin-top:2px" href="{{ route('dashboard.users.show', $order->user?->id) }}">
                                    <x-SVG.eye style="height: 1.4rem;width:1.4rem">
                                    </x-SVG.eye>
                                </a>
                            </div>
                            <hr />
                            <div class="price-details">
                                <h6 class="price-title">{{ translate('Price Details') }}</h6>
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Order Number') }}</div>
                                        <div class="detail-amt discount-amt text-success"> #{{ $order->order_number }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Items Price') }}</div>
                                        <div class="detail-amt">{{ $order->total_price }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Tax') }}</div>
                                        <div class="detail-amt">{{ $order->tax }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Shipping Cost') }}</div>
                                        <div class="detail-amt">{{ $order->shipping_cost }}</div>
                                    </li>
                                </ul>
                                <hr />
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title detail-total fw-bolder">{{ translate('Total') }}</div>
                                        <div class="detail-amt fw-bolder">{{ $order->total_amount }}</div>
                                    </li>
                                </ul>
                                {{-- <button type="button" class="btn btn-primary w-100 btn-next place-order">Place
                                    Order</button> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Checkout Place Order Right ends -->
                </div>
                <div class="d-flex flex-column">
                    @foreach ($order->orderItems as $item)
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items">
                            <div class="card ecommerce-card">
                                <div class="item-img d-flex justify-content-start" style="padding-right: 35px">
                                    <x-Image.show classes="rounded rounded-2"
                                        style="box-shadow: 3px 6px 11px 0px  rgba(83, 80, 80, 0.952);max-height: 230px"
                                        url="{{ $item->stock?->attache?->upload?->url }}" width="auto" height="auto" />
                                </div>
                                <div class="card-body" style="border-color: transparent;">
                                    <p class="fs-4 fw-bolder col-12">
                                        {{ translate('Seller') . ' : ' . $item->stock->seller->user->fullName }}</p>
                                    <div class="d-flex flex-wrap">
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Product Name') . ' : ' }}
                                            <span class="fs-5 fw-bold"> {{ $item->stock->product->name }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Quantity') . ' : ' }} <span
                                                class="fs-5 fw-bold"> {{ $item->product_quantity }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Price') . ' : ' }} <span
                                                class="fs-5 fw-bold"> {{ $item->price }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Tries') . ' : ' }} <span
                                                class="fs-5 fw-bold"> {{ $item->dispatchs_count }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Status') . ' : ' }}
                                            @switch($item->status)
                                                @case(OrderItemStatus::PENDING)
                                                    <span class="text-warning mt-1">
                                                        <x-SVG.clock style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderItemStatus::APPROVED)
                                                    <span class="text-success mt-1">
                                                        <x-SVG.check-circle style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @case(OrderItemStatus::REJECTED)
                                                    <span class="text-danger mt-1">
                                                        <x-SVG.x-circle style="height: 1.4rem;width:1.4rem" />
                                                    </span>
                                                @break

                                                @default
                                            @endswitch
                                        </span>
                                        @if ($item->status == OrderItemStatus::PENDING)
                                            @can(Permission::ORDER_REDISPATCH->value)
                                                <span class="fs-4 fw-bolder col-6 mt-1" onclick="openDispatchModal(this)"
                                                    sellerUrl="{{ route('dashboard.orders.getSellersForRedispatch', $item->id) }}"
                                                    data-order_item="{{ $item }}">
                                                    <button draggable="false" data-bs-toggle="modal" href="#dispatchModal"
                                                        class="btn btn-rounded btn-md btn-primary">{{ translate('Assign to seller') }}</button></span>
                                            @endcan
                                        @endif
                                    </div>
                                    @can(Permission::ORDER_ITEM_ACCEPT_PERMANENTLY->value)
                                        @if ($item->status === OrderItemStatus::PENDING)
                                            <div class="row">
                                                <div
                                                    class="fs-4 fw-bolder col-6 mt-2 d-flex align-items-center justify-content-start">
                                                    <button class="btn btn-outline-danger"
                                                        onclick="acceptPermanently('{{ $item->id }}')">
                                                        {{ translate('Accept to seller permanently') }}
                                                    </button>
                                                    <form
                                                        action="{{ route('dashboard.orders.item.permanently.accept', $item->id) }}"
                                                        id="accepte-permanently-{{ $item->id }}" method="POST" hidden>
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                </div>
                                                <div class="text-success col-5 mt-2 d-flex align-items-center"><span></span>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan
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
@section('modal')
    <div class="modal fade" style="max-height: 90vh;" id="dispatchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-role">

            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h4 class="modal-title" id="dispatchModalLabel">{{ translate('Change Seller') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-2 bg-transparent">
                    <div id="seller-container" class="bg-transparent"
                        style="height:70vh;padding-bottom: 1.8rem;overflow-y: auto">
                    </div>
                    <x-SVG.loader />
                    <form action="{{ route('dashboard.orders.redispatchManually') }}" id="changeSellerForm"
                        method="POST" class="d-none">
                        @csrf
                        <input type="hidden" id="orderItemInput" name="OrderItem" />
                        <input type="hidden" id="newSellerId" name="sellerId" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="cancel" type="button" class="btn btn-outline-secondary fw-bolder fs-5 waves-effect"
                        data-bs-dismiss="modal" aria-label="Close">{{ translate('Cancel') }}</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('layout-scripts')
    <script>
        function changeSeller(element) {
            var orderIetm = $(element).data('order_item');
            var newSeller = $(element).data('seller_id');
            $('#orderItemInput').val(orderIetm);
            $('#newSellerId').val(newSeller);
            $('#changeSellerForm').submit();
        }

        function acceptPermanently(itemId) {
            $(`#accepte-permanently-${itemId}`).submit();
        }

        function openDispatchModal(elment) {
            $('.loader').fadeIn();
            $('#seller-container').html('');
            let url = $(elment).attr("sellerUrl");
            var orderItem = $(elment).data('order_item');
            $.ajax({
                type: "get",
                url: `${url}`,
                success: function(response) {
                    if (response === false) {
                        errorToast('{{ translate('No Selllers to add') }}')
                    }
                    var html = '';

                    response.forEach(seller => {
                        html += sellerDetails(seller, orderItem);
                    });
                    $('.loader').fadeOut(1000);
                    setTimeout(() => {
                        $('#seller-container').append(html);
                    }, 1050);
                }
            });
        }

        function sellerDetails(seller, orderItem) {
            var currentSeller = seller.id == orderItem?.stock.seller_id;

            if (currentSeller) {
                currentHtml = `
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12 mt-2">
                                    <x-inputs.switch view="h" id="current-${orderItem.id}" label="Activated" disabled checked="true" data-seller_id="${seller.id}" data-order_item="${orderItem.id}" />
                                </div>
                `
            } else {
                currentHtml = `
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12 mt-2">
                                    <x-inputs.switch view="h" id="current-${orderItem.id}" label="Activate" onchange="changeSeller(this)" data-seller_id="${seller.id}" data-order_item="${orderItem.id}" />
                                </div>
                `
            }

            return `
                <div class="col-12 d-flex shadow flex-column justify-content-center mx-auto card mt-2 seller-details"
                    style="min-height:180px;margin-left: auto;margin-right: auto;max-width: 90%;">
                    <div class="row d-flex justify-content-start">
                        <div class="col-lg-3 col-xl-3 col-md-10 col-10 rounded" style="padding-top: 0.7rem">
                            <img style="width: 100%;height: 100%;max-height: 140px;" class="mx-auto rounded rounded-2"
                                src="${seller?.user?.attache?.upload.url}"
                                alt="{{ translate('No image found') }}">
                        </div>

                        <div class="col-lg-9 col-xl-9 col-md-12 col-12 seller-content">
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12 mt-1" >
                                    <span class="fw-bolder fs-4"> {{ translate('Seller') }} : </span  > <span  class="fw-bolder fs-5">
                                         ${seller?.user.name} </span>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12 mt-1">
                                    <span class="fw-bolder fs-4"> {{ translate('Available quantity') }} :</span>  <span  class="fw-bolder fs-5">
                                        ${seller?.stock.qty} </span>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12 mt-2">
                                    <span class="fw-bolder fs-4"> {{ translate('Profit') }} :</span  >  <span  class="fw-bolder fs-5">
                                        ${seller?.stock.price - seller?.stock.purchase_price}
                                        </span  >
                                </div>
                                ${currentHtml}
                            </div>
                        </div>
                    </div>
                </div>
           `
        }
    </script>
@endpush
