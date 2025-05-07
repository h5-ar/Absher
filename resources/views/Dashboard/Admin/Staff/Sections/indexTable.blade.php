@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">
                    {{ translate('Image') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                    {{ translate('Name') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                    {{ translate('Username') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                    {{ translate('Email') }}</th>
                @canany([Permission::STAFF_VIEW->value, Permission::STAFF_UPDATE->value])
                    <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                        {{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($staffs as $key => $staff)
                <tr>
                    <td class="text-nowrap w-10 fs-5 fw-bold text-center">
                        {{ ++$key + ($staffs->currentPage() - 1) * $staffs->perPage() }}</td>
                    <td class="text-nowrap w-20  fs-5 fw-boldtext-capitalize fs-5 text-center">
                        <x-Image.show url="{{ $staff?->attache?->upload?->url }}" />
                    </td>
                    <td class="text-nowrap w-20  fs-5 fw-boldtext-capitalize fs-5 text-center">
                        {{ $staff->fullname ?? '---' }}</td>
                    <td class="text-nowrap w-20 fs-5 fw-bold text-capitalize fs-5 text-center">
                        {{ $staff->username ?? '---' }}</td>
                    <td class="text-nowrap w-20 fs-5 fw-bold text-capitalize fs-5 text-center">
                        {{ $staff->email ?? '---' }}
                    </td>
                    @canany([Permission::STAFF_VIEW->value, Permission::STAFF_UPDATE->value])
                        <td class="text-nowrap w-30  fs-5 fw-boldtext-capitalize fs-5 text-center">
                            @can(Permission::STAFF_VIEW->value)
                                <x-Button.show route="{{ route('dashboard.staffs.show', $staff->id) }}" />
                            @endcan
                            @can(Permission::STAFF_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.staffs.edit', $staff->id) }}" />
                            @endcan
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
<div class="px-1">
    {{ $staffs->links('components.Pagination.ajax') }}
</div>
