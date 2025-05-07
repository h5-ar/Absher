@use('App\Enums\CouponType')
@use('App\Enums\DiscountType')
@use('App\Enums\Permission')

<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-5 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-30 fs-5 fw-bolder text-center">
                    {{ translate('Name') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('Start date') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('End date') }}</th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('Type') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('Code') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('Discount Value') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                    {{ translate('Users Count') }}
                </th>
                @canany([Permission::COUPON_UPDATE->value, Permission::COUPON_DELETE->value])
                    <th scope="col" class="text-nowrap w-15 fs-5 fw-bolder text-center">
                        {{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($coupons as $key => $coupon)
                <tr>
                    <td class="text-nowrap w-10 text-center">
                        {{ ++$key + ($coupons->currentPage() - 1) * $coupons->perPage() }}</td>
                    <td class="text-nowrap w-15 text-capitalize fs-5 text-center">
                        {{ $coupon->name }}
                    </td>
                    <td class="text-nowrap w-15 text-capitalize fs-5 text-center">
                        {{ $coupon->start_date ? date('Y-m-d', strtotime($coupon->start_date)) : '----' }}</td>
                    <td class="text-nowrap w-15 text-capitalize fs-5 text-center">
                        {{ $coupon->end_date ? date('Y-m-d', strtotime($coupon->end_date)) : '----' }}</td>
                    <td class="text-wrap w-15 text-capitalize fs-5 text-center">
                        {{ translate($coupon->type->name) }}
                    </td>
                    <td class="text-wrap w-15 text-capitalize fs-5 text-center">
                        {{ $coupon->code }}
                    </td>
                    <td class="text-wrap w-15 text-capitalize fs-5 text-center"
                        @if (app()->getLocale() == 'en') style="direction:ltr" @endif>
                        @if ($coupon->discount_type == DiscountType::PERCENTAGE)
                            {{ $coupon->discount_value . '%' }}
                        @else
                            {{ $coupon->discount_value . ' ' . translate('SP') }}
                        @endif
                    </td>
                    <td class="text-wrap w-15 text-capitalize fs-5 text-center">
                        @if ($coupon->type == CouponType::PUBLIC)
                            {{ translate('All') }}
                        @else
                            {{ $coupon->users_count }}
                        @endif
                    </td>
                    @canany([Permission::COUPON_UPDATE->value, Permission::COUPON_DELETE->value])
                        <td class="text-nowrap w-8 text-capitalize fs-5 text-center">
                            @can(Permission::COUPON_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.coupons.edit', $coupon->id) }}" />
                            @endcan
                            @can(Permission::COUPON_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.coupons.delete', $coupon->id) }}" />
                            @endcan
                        </td>
                    @endcanany

                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $coupons->links('components.Pagination.ajax') }}
</div>
