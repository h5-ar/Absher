<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Price') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Bus') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Date') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Day') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('From') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('To 1') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('To 2') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('To 3') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('To 4') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('To 5') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trips as $key => $trip)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($trips->currentPage() - 1) * $trips->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $trip->price }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $trip->bus_id }} {{ translate($trip->bus->type) }}

                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $trip->take_off_at }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->day) }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->from) ?? '---' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->to1) ?? '---' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->to2 )?? '---' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->to3) ?? '---' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->to4 )?? '---' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($trip->path->to5) ?? '---' }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.edit route="{{ route('trip.edit', $trip->id) }}" />
<form action="{{ route('trip.delete', $trip->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('هل أنت متأكد؟')">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </form>                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>
<div class="px-1 mt-3">
    {{ $trips->links('components.Pagination.ajax') }}
</div>
