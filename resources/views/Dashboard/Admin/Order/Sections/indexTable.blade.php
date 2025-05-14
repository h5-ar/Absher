@use('App\Enums\Permission')
@use('App\Enums\ShippingStatus')
@use('App\Enums\OrderStatus')
@push('styles')
    <style>
        .shaking {
            animation: jump-shaking 0.83s infinite;
        }

        .shaking {
            display: inline-block;
        }

        @keyframes jump-shaking {
            35% {
                transform: rotate(17deg)
            }

            55% {
                transform: rotate(-17deg)
            }

            65% {
                transform: rotate(17deg)
            }

            75% {
                transform: rotate(-17deg)
            }

            100% {
                transform: rotate(0)
            }
        }
    </style>
@endpush
<div class="table-responsive p-2 pb-4 mb-2">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-4 fw-bolder">{{ translate('Order Number') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Username') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Status') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Total') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Tax') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Payment method') }}</th>
                <th class="text-center fs-4 fw-bolder">{{ translate('Shipping') }}</th>
                @canany([Permission::ORDER_VIEW->value])
                    <th class="text-center fs-4 fw-bolder">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $order->order_number }}
                    </td>
                    <td class="text-center fs-5 fw-bolder"> {{ $order->user?->fullName }}</td>
                    <td class="text-center fs-5 fw-bolder">
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
                        {{-- {{ translate(ucfirst($order->status->name), 'orders') }} --}}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $order->total_price + $order->tax + $order->shipping_cost - $order->discount }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">{{ $order->tax }}</td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ translate(str($order->payment_method->name)->replace('_', ' ')->lower()->ucfirst()) }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        <span class="@if ($order->status == OrderStatus::OUT_FOR_DELIVERY) text-dark shaking @endif"
                            style="
                            @if ($order->status == OrderStatus::OUT_FOR_DELIVERY) color:black @elseif($order->status == OrderStatus::COMPLETED)  color: #7dbfbb @else color:red @endif
                            ">
                            <x-SVG.truck style="height: 1.4rem;width:1.4rem" />
                        </span>
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                data-bs-toggle="dropdown">
                                <x-SVG.more-vertical />
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @can(Permission::ORDER_VIEW->value)
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.orders.show', $order->order_number) }}">
                                        <span class="me-50"><x-SVG.eye /> </span>
                                        <span>{{ translate('Show') }}</span>
                                    </a>
                                @endcan
                                @if ($order->status === OrderStatus::ACCEPTED || $order->status === OrderStatus::OUT_FOR_DELIVERY)
                                    @can(Permission::ORDER_AS_COMPLETE->value)
                                        <a class="dropdown-item" href="#"
                                            data-url="{{ route('dashboard.orders.status.completed', $order->order_number) }}"
                                            onclick="updateStatus(this,'completed')">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Mark as Completed') }}</span>
                                        </a>
                                    @endcan
                                    @if ($order->status === OrderStatus::ACCEPTED)
                                        @can(Permission::ORDER_AS_OUT_FOR_DELIVERY->value)
                                            <a class="dropdown-item" href="#"
                                                data-url="{{ route('dashboard.orders.status.delivery', $order->order_number) }}"
                                                onclick="updateStatus(this,'delivery')">
                                                <span class="me-50"><x-SVG.eye /> </span>
                                                <span>{{ translate('Mark as Out for delivery') }}</span>
                                            </a>
                                        @endcan

                                        {{-- <a class="dropdown-item" href="#"
                                            data-url="{{ route('dashboard.orders.make.delivered', $order->id) }}"
                                            onclick="submitForm(this,'{{ $order->id }}')">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Mark as Out for delivery') }}</span>
                                        </a> --}}
                                    @endif
                                @endif
                                @if ($order->status === OrderStatus::PENDING)
                                    @can(Permission::ORDER_AS_ACCEPTED->value)
                                        <a class="dropdown-item" href="#"
                                            data-url="{{ route('dashboard.orders.make.accepted', $order->id) }}"
                                            onclick="submitForm(this,'{{ $order->id }}')">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Mark as Accepted') }}</span>
                                        </a>
                                    @endcan
                                    @can(Permission::ORDER_AS_REJECTED->value)
                                        <a class="dropdown-item" href="#"
                                            data-url="{{ route('dashboard.orders.make.rejected', $order->id) }}"
                                            onclick="submitForm(this,'{{ $order->id }}')">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Mark as Rejected') }}</span>
                                        </a>
                                    @endcan
                                @endif
                                <form id="order-update-status-{{ $order->id }}" method="POST" hidden>
                                    @csrf
                                    @method('PUT')
                                </form>
                                <a class="dropdown-item"
                                    href="{{ route('dashboard.orders.invoice.admin', $order->order_number) }}"
                                    target="_blank">
                                    <span class="me-50"><x-SVG.file-minus /> </span>
                                    <span>{{ translate('Invoice') }}</span>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center fs-4 fw-bolder">
                            {{ translate('No Data') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-1">
        {{ $orders->links('components.Pagination.ajax') }}
    </div>
