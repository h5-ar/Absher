<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('First Name') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Last Name') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Phone') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($managers as $key => $manager)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($managers->currentPage() - 1) * $managers->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $manager->first_name }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $manager->last_name }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $manager->phone}}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.edit route="{{ route('edit.manager', $manager->id) }}" />
                    <x-Button.delete route="{{ route('delete.manager',$manager->id) }}" />
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