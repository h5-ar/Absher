<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Company') }}
                </th>
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
            @forelse ($buses as $key => $bus)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($buses->currentPage() - 1) * $buses->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{$bus->Company_id}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($bus->type)}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $bus->seats_count }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.edit route="{{ route('SAbus.edit', $bus->id) }}" />
                    <x-Button.delete route="{{ route('SAbus.delete',$bus->id) }}" />
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
    {{ $buses->links('components.Pagination.ajax') }}
</div>