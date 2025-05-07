<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Image') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('SKU') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Seller') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Updated By') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Quantity') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Price') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Purchase Price') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Discount Type') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Discount Value') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Updated At') }}</th>

            </tr>
        </thead>
        @php
            $products = [];
        @endphp
        <tbody>
            @forelse ($stocks as $stock)
                @foreach ($stock->modifications as $modifiedStock)
                    <tr>
                        <td colspan="1" class="text-center fs-6 fw-bolder">

                            <x-Image.show width="60px" height="60px" url="{{ asset($stock->attache->upload->url) }}" />
                        </td>
                        @php
                            $sku = $stock->sku;
                            $sku = explode('-', $sku);
                            unset($sku[0]);
                            $sku = implode('-', $sku);
                        @endphp
                        <td colspan="1" class="text-center fs-6 fw-bolder" style="white-space: nowrap">
                            {{ $sku }}
                        </td>
                        <td colspan="1" class="text-center fs-6 fw-bolder">
                            {{ $stock->seller->user->fullname }}</td>
                        <td colspan="1" class="text-center fs-6 fw-bolder">
                            {{ $modifiedStock->updatedBy->fullname }}
                        </td>
                        <td colspan="1" class="text-center fs-6 ">
                            <div class="d-flex flex-column">
                                <span style="white-space: nowrap" class="fw-bold"><span class="fw-bolder">
                                        {{ translate('before') }}: </span> {{ $modifiedStock->old_quantity }}</span>
                                <span style="white-space: nowrap" class="fw-bold"><span class="fw-bolder">
                                        {{ translate('after') }}: </span>{{ $modifiedStock->new_quantity }}</span>
                            </div>
                        </td>
                        <td colspan="1" class="text-center fs-6 ">
                            <div class="d-flex flex-column">
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('before') }}:
                                    </span> {{ $modifiedStock->old_price }}</span>
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('after') }}:
                                    </span>{{ $modifiedStock->new_price }}</span>
                            </div>
                        </td>
                        <td colspan="1" class="text-center fs-6 ">
                            <div class="d-flex flex-column">
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('before') }}:
                                    </span> {{ $modifiedStock->old_purchase_price }}</span>
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('after') }}:
                                    </span>{{ $modifiedStock->new_purchase_price }}</span>
                            </div>
                        </td>
                        <td colspan="1" class="text-center fs-6 ">
                            <div class="d-flex flex-column">
                                <span style="white-space: nowrap" class="fw-bolder"><span class="fw-bolder">
                                        {{ translate('before') }}:
                                    </span> {{ translate($modifiedStock->old_discount_type) }}</span>
                                <span style="white-space: nowrap" class="fw-bolder"><span class="fw-bolder">
                                        {{ translate('after') }}:
                                    </span>{{ translate($modifiedStock->new_discount_type) }}</span>
                            </div>
                        </td>
                        <td colspan="1" class="text-center fs-6 ">
                            <div class="d-flex flex-column">
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('before') }}:
                                    </span> {{ $modifiedStock->old_discount_value }}</span>
                                <span class="fw-bold" style="white-space: nowrap"><span class="fw-bolder">
                                        {{ translate('after') }}:
                                    </span>{{ $modifiedStock->new_discount_value }}</span>
                            </div>
                        </td>
                        <td colspan="1" class="text-center fs-6 fw-bolder">
                            {{ $modifiedStock->updated_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="10" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{-- {{ $stocks->links('components.Pagination.ajax') }} --}}
</div>
