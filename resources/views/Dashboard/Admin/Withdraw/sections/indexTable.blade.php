@use('App\Enums\Permission')
<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4 ">{{ translate('Request Number') }}</th>
                <th class="text-center fs-4">{{ translate('Seller') }}</th>
                <th class="text-center fs-4">{{ translate('Amount') }}</th>
                <th class="text-center fs-4">{{ translate('Requested At') }}</th>
                @canany([Permission::WITHDRAW_ACCEPT->value, Permission::WITHDRAW_REJECT->value])
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $key=>$request)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $request->request_number }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        <a href="{{ route('dashboard.sellers.show', $request?->seller->id) }}">
                            {{ $request?->seller?->user?->fullName }}
                        </a>
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $request->amount }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $request->created_at->format('Y-m-d') }}
                    </td>
                    @canany([Permission::WITHDRAW_ACCEPT->value, Permission::WITHDRAW_REJECT->value])
                        <td class="text-nowrap w-30 text-center">
                            @can(Permission::WITHDRAW_ACCEPT->value)
                                <a id="status-{{ $request->id }}-accept" onclick="changeStatus(this,true)"
                                    url="{{ route('dashboard.withdraw.requests.updateStatus', $request->id) }}"
                                    href="#acceptModal" data-bs-toggle="modal" class="text-success">
                                    <x-SVG.check-circle style="width: 1.4rem;height: 1.4rem" stroke='3' />
                                </a>
                            @endcan
                            @can(Permission::WITHDRAW_REJECT->value)
                                <a id="status-{{ $request->id }}-reject"
                                    url="{{ route('dashboard.withdraw.requests.updateStatus', $request->id) }}"
                                    href="#rejectModal" data-bs-toggle="modal" onclick="changeStatus(this,false)"
                                    class="text-danger">
                                    <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                </a>
                            @endcan
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

</div>
<div class="px-1 mt-3">
    {{ $requests->links('components.Pagination.ajax') }}
</div>

@push('layout-scripts')
    <script>
        function changeStatus(elem, accepted) {
            event.preventDefault();
            url = $(elem).attr('url');
            let html =
                `<input id="status" name="status" class="hidden" type="checkbox"`
            if (accepted) {
                html += `checked="checked" />`
            } else {
                html += ` />`
            }
            $("#acceptModalForm").prepend(html);
            $("#acceptModalForm").attr('action', url);
            $("#rejectModalForm").attr('action', url);
        }
    </script>
@endpush
