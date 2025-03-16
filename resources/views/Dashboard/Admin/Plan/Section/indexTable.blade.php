<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Plan Name') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Trips Number') }}
                </th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Type Bus') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Status') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Price') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($plans as $key => $plan)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                {{ ++$key + ($plans->currentPage() - 1) * $plans->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $plan->name }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $plan->trips_number}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $plan->type_bus }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $plan->available }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $plan->price }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.edit route="{{ route('plan.edit', $plan->id) }}" />
                    <x-Button.delete route="{{ route('plan.delete',$plan->id) }}" />
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>