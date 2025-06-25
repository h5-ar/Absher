<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Type') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Number Of Seats') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
             @forelse ($shipments as $key => $shipment)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($shipments->currentPage() - 1) * $shipments->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($shipment->size)}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $shipment->user_id }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.edit route="{{ route('shipping.edit', $shipment->id) }}" />
                    <x-Button.delete route="{{ route('shipping.delete',$shipment->id) }}" />
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
        {{ $shipments->links('components.Pagination.ajax') }}
</div>