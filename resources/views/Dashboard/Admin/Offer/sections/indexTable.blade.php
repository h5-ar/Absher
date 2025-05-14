@use('App\Enums\Permission')
@use('App\Enums\OfferType')

<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-4">{{ translate('Name') }}</th>
                <th class="text-center fs-4">{{ translate('Arabic Name') }}</th>
                <th class="text-center fs-4">{{ translate('Type') }}</th>
                <th class="text-center fs-4">{{ translate('Value') }}</th>
                <th class="text-center fs-4">{{ translate('Status') }}</th>
                @canany([Permission::PRODUCT_UPDATE->value, Permission::PRODUCT_DELETE->value])
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($offers as $offer)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $offer->name }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ getTranslation($offer, 'name') }}</td>
                    <td class="text-center fs-5 fw-bolder">{{ translate(str()->lower($offer->type->name)) }}</td>
                    <td class="text-center fs-5 fw-bolder">
                        @switch($offer->type)
                            @case(OfferType::PERCENTAGE)
                                {{ $offer->value }}%
                            @break

                            @case(OfferType::DISCOUNT)
                                {{ $offer->value }}
                            @break

                            @default
                        @endswitch
                    </td>
                    <td class="fs-5 fw-bolder d-grid justify-content-center">
                        <x-inputs.switch id="offer-{{ $offer->id }}" checked="{{ $offer->is_active }}"
                            class="form-check-input" data-value="{{ $offer->is_active }}"
                            data-offerid="{{ $offer->id }}" onchange="updateActivate(this)" />
                    </td>
                    @canany([Permission::PRODUCT_UPDATE->value, Permission::PRODUCT_DELETE->value])
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                    data-bs-toggle="dropdown">
                                    <x-SVG.more-vertical />
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can(Permission::PRODUCT_UPDATE->value)
                                        <a class="dropdown-item" href="{{ route('dashboard.offers.show', $offer->id) }}">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Show') }}</span>
                                        </a>
                                    @endcan

                                    @can(Permission::PRODUCT_DELETE->value)
                                        <a class="dropdown-item" onclick="openDeleteModal(this)" data-bs-toggle="modal"
                                            deleteUrl="{{ route('dashboard.offers.delete', $offer->id) }}" href="#deleteModal"
                                            role="button">
                                            <span class="me-50"><x-SVG.trash /></span>
                                            <span>{{ translate('Delete') }}</span>
                                        </a>
                                    @endcan

                                </div>
                            </div>
                        </td>
                    @endcanany
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center fs-4 fw-bolder">
                            {{ translate('No Data') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-1">
            {{ $offers->links('components.Pagination.ajax') }}
        </div>
    </div>
