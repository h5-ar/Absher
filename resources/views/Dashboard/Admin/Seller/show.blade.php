@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\DiscountType')
@use('App\Enums\OrderStatus')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Seller Details') }}
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
                            <x-Image.show url="{{ $seller?->user?->attache?->upload?->url }}" />

                            <div class="coupons input-group input-group-merge d-flex justify-content-between">
                                <span class="fs-4 fw-bolder">{{ translate('Name') . ' : ' }}
                                    <span class="fs-4 fw-bolder">
                                        {{ $seller->user->fullName === ' ' ? '---' : $seller->user->fullName }}
                                    </span>
                                </span>
                            </div>
                            <hr />
                            <div class="price-details">
                                <h6 class="price-title">{{ translate('Details') }}</h6>
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Phone Number') }}</div>
                                        <div class="detail-amt discount-amt "> {{ $seller->user->phone_number ?? '---' }}
                                        </div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Email') }}</div>
                                        <div class="detail-amt">{{ $seller->user->email ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Username') }}</div>
                                        <div class="detail-amt">{{ $seller->user->username ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Birth Date') }}</div>
                                        <div class="detail-amt">{{ $seller->user->birth_date ?? '---' }}
                                        </div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Bank Name') }}</div>
                                        <div class="detail-amt">{{ $seller->bank_name ?? '---' }}
                                        </div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Account Number') }}</div>
                                        <div class="detail-amt">{{ $seller->account_number ?? '---' }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title fw-bolder">{{ translate('Cash') }}</div>
                                        <div class="detail-amt">{{ $seller->cash ? translate('Yes') : translate('No') }}
                                        </div>
                                    </li>
                                </ul>
                                @canany([Permission::WITHDRAW_HISTORY->value, Permission::WITHDRAW_CREATE->value])
                                    <div class="row d-flex justify-content-around">
                                        @can(Permission::WITHDRAW_HISTORY->value)
                                            <a href="#withdrawHistoryModal" data-bs-toggle="modal"
                                                class="btn btn-danger text-nowrap"
                                                style="width: 48% ">{{ translate('Withdraws History') }}</a>
                                        @endcan
                                        @can(Permission::WITHDRAW_CREATE->value)
                                            <a href="#makeWithdraw" data-bs-toggle="modal" class="btn btn-success"
                                                style="width:48%">{{ translate('Withdraw') }}</a>
                                        @endcan

                                    </div>
                                @endcanany
                                <div class="row mt-1">
                                    <a href="{{ route('dashboard.sellers.edit', $seller->user->id) }}"
                                        class="btn btn-primary w-100">{{ translate('Edit') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>{{ translate('Invoices') }}</h4>
                    <div class="card">
                        <div class="d-flex justify-content-between p-1 align-items-center">
                            @foreach ($seller->invoices as $invoice)
                                {{-- <p class="m-0">{{ $invoice->order->order_number }}</p> --}}
                                <p class="m-0">{{ $invoice->invoice_number }}</p>
                                <p class="m-0">{{ $invoice->name }}</p>
                                <p class="m-0"><a class="text-success" href="{{ $invoice->url }}" target="_blank">
                                        <x-SVG.eye style="width: 1.4rem;height: 1.4rem" stroke='3' />
                                    </a></p>
                            @endforeach
                        </div>
                    </div>
                    <!-- Checkout Place Order Right ends -->
                </div>
                <div class="d-flex flex-column">
                    @foreach ($orders as $order)
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items">
                            <div id="cardId" class="card ecommerce-card p-1" style="grid-template-columns:1fr">
                                {{-- <div class="item-img d-flex justify-content-start" style="padding-right: 35px">
                                    <x-Image.show classes="rounded rounded-2"
                                        style="box-shadow: 3px 6px 11px 0px  rgba(83, 80, 80, 0.952);"
                                        url="{{ $order?->orderItem?->stock?->attache?->upload?->url }}" width="auto"
                                        height="auto" />
                                </div> --}}

                                <div class="card-body" style="border-color: transparent;">
                                    <span href="{{ route('dashboard.orders.show', $order->order_number) }}"
                                        class="fs-4 fw-bolder ">
                                        {{ translate('Order Number') . ' : ' }} <a
                                            href="{{ route('dashboard.orders.show', $order->order_number) }}">{{ $order->order_number }}</a>
                                    </span>
                                    <div class="d-flex flex-wrap">
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Total Price') . ' : ' }}
                                            <span class="fs-5 fw-bold"> {{ $order->items_total_price }}</span></span>
                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Items Count') . ' : ' }}
                                            <span class="fs-5 fw-bold">
                                                {{ $order->order_items_count }}</span></span>
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

                                        <span class="fs-4 fw-bolder col-6 mt-1">{{ translate('Address') . ' : ' }}
                                            <span class="fs-5 fw-bold">
                                                {{ $address?->city }} ,&nbsp; {{ $address?->line_one }}</span></span>

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

@section('modal')
    <div class="modal fade" id="withdrawHistoryModal" tabindex="-2" aria-labelledby="withdrawHistoryModalLable"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="withdrawHistoryModalLable">{{ translate('Withdraws History') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive p-2 pb-4 mb-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center fs-4 ">{{ translate('Request Number') }}</th>
                                    <th class="text-center fs-4">{{ translate('Seller') }}</th>
                                    <th class="text-center fs-4">{{ translate('Amount') }}</th>
                                    <th class="text-center fs-4">{{ translate('Requested At') }}</th>
                                    <th class="text-center fs-4">{{ translate('Modified At') }}</th>
                                    <th class="text-center fs-4">{{ translate('Status') }}</th>
                                    @canany([Permission::WITHDRAW_ACCEPT->value, Permission::WITHDRAW_REJECT->value])
                                        <th class="text-center fs-4">{{ translate('Attachment') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $key=>$request)
                                    <tr>
                                        <td class="text-center fs-5 fw-bolder">
                                            {{ $request->request_number }}
                                        </td>
                                        <td class="text-center fs-5 fw-bolder">
                                            <a href="{{ route('dashboard.sellers.show', $request?->seller->id) }}">
                                                {{ $request?->seller?->user?->fullName }}
                                            </a>
                                        </td>
                                        <td class="text-center fs-5 fw-bolder">
                                            {{ $request->amount }}
                                        </td>
                                        <td class="text-center fs-5 fw-bolder">
                                            {{ $request->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="text-center fs-5 fw-bolder">
                                            {{ $request->updated_at->format('Y-m-d') }}
                                        </td>
                                        <td class="text-center fs-5 fw-bolder">
                                            @switch($request?->status)
                                                {{-- rejected     --}}
                                                @case(2)
                                                    <span id="status-{{ $request->id }}-false" class="text-danger">
                                                        <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                                    </span>
                                                @break

                                                {{-- accepted --}}
                                                @case(1)
                                                    <span class="text-success">
                                                        <x-SVG.check-circle style="width: 1.4rem;height: 1.4rem" />
                                                    </span>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="text-nowrap w-30 text-center">
                                            @switch($request?->status)
                                                {{-- rejected     --}}
                                                @case(2)
                                                    <span id="status-{{ $request->id }}-false" class="text-danger">
                                                        {{ $request->excuse }}
                                                    </span>
                                                @break

                                                {{-- accepted --}}
                                                @case(1)
                                                    <x-Image.show url="{{ asset('storage/' . $request->image) }}" />
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center fs-4 fw-bolder">
                                                {{ translate('No Data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-start" id="makeWithdraw" tabindex="-1" aria-labelledby="makeWithdrawLabel"
            aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="makeWithdrawLabel">
                            {{ translate('choose the orders to make a withdraw') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive p-2  ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center fs-4 d-flex">
                                            <label class="container p-0">
                                                <input type="checkbox" name="all" id="orders-all" autocomplete="off">
                                                <div class="checkmark"></div>
                                            </label>
                                        </th>
                                        <th class="text-center fs-4 ">{{ translate('Order Number') }}</th>
                                        <th class="text-center fs-4">{{ translate('Order Price') }}</th>
                                        <th class="text-center fs-4">{{ translate('IN recovery') }}</th>
                                        <th class="text-center fs-4">{{ translate('Requested At') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($completedSellerOrders as $key => $order)
                                        @php
                                            $inRecovery = $order->getInRecovery($seller->id);
                                        @endphp
                                        <tr>
                                            <td class="text-center fs-5 fw-bolder">
                                                @if (!$inRecovery && !$order->order_withdraw_exists)
                                                    <input type="checkbox" name="order" autocomplete="off"
                                                        id="order-{{ $order->id }}">
                                                @endif
                                            </td>
                                            <td class="text-center fs-5 fw-bolder">
                                                {{ $order->order_number }}
                                            </td>
                                            <td class="text-center fs-5 fw-bolder">
                                                {{ $order->order_total_price }}
                                            </td>
                                            <td class="text-center fs-5 fw-bolder">
                                                @switch($inRecovery)
                                                    @case(0)
                                                        <span id="recovery-{{ $order->id }}-false" class="text-danger">
                                                            <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                                        </span>
                                                    @break

                                                    @case(1)
                                                        <span class="text-success">
                                                            <x-SVG.check-circle style="width: 1.4rem;height: 1.4rem" />
                                                        </span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td class="text-center fs-5 fw-bolder">
                                                {{ $order->orderWithdraw?->created_at?->format('Y-m-d') ?? '--' }}
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center fs-4 fw-bolder">
                                                    {{ translate('No Data') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a id="withdraw-all" href="#acceptModal" data-bs-toggle="modal"
                                    class="btn btn-larage btn-primary hidden" style="margin-left: 20px">
                                    {{ translate('Withdraw') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary waves-effect waves-float waves-light"
                            data-bs-dismiss="modal">
                            {{ translate('Close') }}
                        </button>
                    </div>
                </div>
            </div>
            </div>

            <x-Modals.input modalId="acceptModal" inputId="image" inputName="image" inputType="file"
                description="Please Upload The Evidence document" title="Accept Withdraw Request" label="Document File"
                accept="image/*" />
        @endsection
        @push('layout-scripts')
            <script>
                let orders = @json($completedSellerOrders->pluck('order_total_price', 'id'));

                let checkedBoxes = {};
                let allButton = $("#orders-all");

                allButton.click(function(e) {
                    var btn = document.getElementById("orders-all");

                    let buttons = document.getElementsByName('order');
                    buttons.forEach(element => {
                        element.checked = btn.checked;

                        if (btn.checked) {
                            checkedBoxes[element.id] = orders[element.id.replace('order-', '')];
                        } else {
                            checkedBoxes = {};
                        }
                    });

                    if (Object.keys(checkedBoxes).length > 0) {
                        $("#withdraw-all").removeClass('hidden');
                    } else {
                        $("#withdraw-all").addClass('hidden');
                    }
                });

                checkBoxes = $('tbody [type="checkbox"]');
                $.map(checkBoxes, function(element, indexOrKey) {
                    $(element).click(function(e) {
                        if (element.checked) {
                            checkedBoxes[element.id] = orders[element.id.replace('order-', '')];
                            if (Object.keys(checkedBoxes).length == checkBoxes.length) {
                                document.getElementById("orders-all").checked = true;
                            }
                            $('#withdraw-all').removeClass('hidden');
                        } else {
                            delete checkedBoxes[element.id];
                            document.getElementById("orders-all").checked = false;
                            if (Object.keys(checkedBoxes).length == 0) {
                                $('#withdraw-all').addClass('hidden');
                            }
                        }

                    });
                });

                $('#acceptModalForm').submit(function(e) {
                    e.preventDefault();
                    let form = new FormData($('#acceptModalForm')[0]);
                    form.append('orders', JSON.stringify(checkedBoxes));
                    form.append('seller_id', '{{ $seller->id }}')
                    form.append('_token', "{{ csrf_token() }}")
                    console.log(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.withdraw.requests.makeWithdraw') }}",
                        data: form,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Prevent jQuery from setting contentType
                        success: function(response) {
                            window.location.reload();
                        }
                    });

                });
            </script>
        @endpush
