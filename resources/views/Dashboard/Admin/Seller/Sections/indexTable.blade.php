@use('App\Enums\Permission')
@use('App\Enums\SellerStatus')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Name') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Email') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('City') }}</th>
                @canany([Permission::SELLER_SHOW->value, Permission::SELLER_SUSPEND->value])
                    <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Actions') }}</th>
                @endcanany
                @canany([Permission::SELLER_ACCEPT->value, Permission::SELLER_REJECT->value])
                    <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Status') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($sellers as $key => $seller)
                <tr>
                    <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                        {{ ++$key + ($sellers->currentPage() - 1) * $sellers->perPage() }}</td>

                    <td class="text-nowrap w-20 text-capitalize fs-5 fw-bolder text-center">
                        {{ $seller?->user?->name }}
                    </td>
                    <td class="text-nowrap w-20 text-capitalize fs-5 fw-bolder text-center">
                        {{ $seller?->user?->email }}
                    </td>
                    <td class="text-nowrap w-20 text-capitalize fs-5 fw-bolder text-center">{{ $seller->city }}
                    </td>
                    @canany([Permission::SELLER_SHOW->value, Permission::SELLER_SUSPEND->value])
                        <td class="text-nowrap w-10 text-capitalize  text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @can(Permission::SELLER_SHOW->value)
                                    <x-Button.show route="{{ route('dashboard.sellers.show', $seller->id) }}" />
                                @endcan
                                @can(Permission::SELLER_SUSPEND->value)
                                    <a onclick="openSuspendModal(this)" data-bs-toggle="modal" href="#suspendModal"
                                        suspendUrl="{{ route('dashboard.sellers.switchActivation', $seller->id) }}"
                                        data-message="{{ $seller->active }}">
                                        @if ($seller->active == true)
                                            <span class="text-success" title="{{ translate('Suspend') }}"> <x-SVG.user-check
                                                    style="height: 1.4rem;width:1.4rem" />
                                            </span>
                                        @else
                                            <span class="text-danger" title="{{ translate('Release') }}">
                                                <x-SVG.user-x style="height: 1.4rem;width:1.4rem" />
                                            </span>
                                        @endif
                                    </a>
                                @endcan
                            </div>
                        </td>
                    @endcanany

                    @canany([Permission::SELLER_ACCEPT->value, Permission::SELLER_REJECT->value])
                        <td class="text-nowrap w-10 text-capitalize  text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if ($seller->verified != SellerStatus::ACCEPTED->value)
                                    @can(Permission::SELLER_ACCEPT->value)
                                        <form id="seller-{{ $seller->id }}-accept-status"
                                            action="{{ route('dashboard.sellers.accept', $seller->id) }}" method="POST">
                                            @csrf
                                            <a>
                                                <span class="text-success" title="{{ translate('Accept Seller') }}"
                                                    onclick="submitForm('seller-{{ $seller->id }}-accept-status')">
                                                    <x-SVG.check-circle style="height: 1.4rem;width:1.4rem" />
                                                </span>
                                            </a>
                                        </form>
                                    @endcan
                                @else
                                    <span
                                        class="text-nowrap text-capitalize fs-5 fw-bolder text-center">{{ SellerStatus::matchEnum($seller->verified) }}
                                    </span>
                                @endif
                                @if ($seller->verified == SellerStatus::PENDING->value)
                                    @can(Permission::SELLER_REJECT->value)
                                        <form id="seller-{{ $seller->id }}-reject-status"
                                            action="{{ route('dashboard.sellers.reject', $seller->id) }}" method="get">
                                            @csrf
                                            <a>
                                                <span class="text-danger" title="{{ translate('Reject Seller') }}"
                                                    onclick="submitForm('seller-{{ $seller->id }}-reject-status')">
                                                    <x-SVG.x-circle style="height: 1.4rem;width:1.4rem" />
                                                </span>
                                            </a>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    @endcanany
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-2 px-1">
    {{ $sellers->links('components.Pagination.ajax') }}
</div>
