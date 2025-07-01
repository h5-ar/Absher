<div class="table-responsive">
    <table class="table mb-0" id="reservationsTable">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Type Notification') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Notification For') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Read At') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Sent At') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifications as $key => $notification)
            <tr data-notification-id="{{ $notification->id }}">
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($notifications->currentPage() - 1) * $notifications->perPage() }}
                </td>

                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $notification->type }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $notification->notifiable_type }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $notification->read_at }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $notification->created_at }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.show route="{{ route('SAnotifications.details', $notification->id) }}" />
                    <x-Button.delete route="{{ route('SAdelete.notification', $notification->id) }}" />

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center fs-4 fw-bolder py-4">{{ translate('No Data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
    {{ $notifications->links('components.Pagination.ajax') }}
</div>