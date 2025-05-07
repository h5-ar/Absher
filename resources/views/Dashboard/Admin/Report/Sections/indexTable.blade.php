@use('App\Enums\Permission')

<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap fs-4 fw-bolder w-10 text-center">#</th>
                <th scope="col" class="text-nowrap fs-4 fw-bolder w-30 text-center">{{ translate('Name') }}
                </th>
                <th scope="col" class="text-nowrap fs-4 fw-bolder w-30 text-center">{{ translate('Email') }}
                </th>
                <th scope="col" class="text-nowrap fs-4 fw-bolder w-30 text-center">
                    {{ translate('Description') }}</th>
                <th scope="col" class="text-nowrap fs-4 fw-bolder w-30 text-center">
                    {{ translate('Type') }}</th>
                @can(Permission::REPORT_DELETE->value)
                    <th scope="col" class="text-nowrap fs-4 fw-bolder w-10 text-center">
                        {{ translate('Actions') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $key => $report)
                <tr>
                    <td class="text-nowrap w-10 fs-5 fw-bold text-center">
                        {{ ++$key + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                    <td class=" w-30 text-capitalize fs-5 fw-bold text-center">
                        {{ $report->name }}</td>
                    <td class=" w-30 text-capitalize fs-5 fw-bold text-center">
                        {{ $report->email }}</td>
                    <td class=" w-30 text-capitalize fs-5 fw-bold text-center">
                        {{ $report->description }}</td>
                    <td class=" w-30 text-capitalize fs-5 fw-bold text-center">{{ translate($report->type) }}</td>
                    @can(Permission::REPORT_DELETE->value)
                        <td class="text-nowrap w-8 text-capitalize fs-5 fw-bold text-center">
                            <x-Button.delete route="{{ route('dashboard.reports.delete', $report->id) }}" />
                        </td>
                    @endcan
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
    {{ $reports->links('components.Pagination.ajax') }}
</div>
