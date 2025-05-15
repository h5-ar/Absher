@use('App\Enums\Permission')
<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4 ">{{ translate('Request Number') }}</th>
                <th class="text-center fs-4">{{ translate('Seller') }}</th>
                <th class="text-center fs-4">{{ translate('Amount') }}</th>
                <th class="text-center fs-4">{{ translate('Requested At') }}</th>
                <th class="text-center fs-4">{{ translate('Modified At') }}</th>
                <th class="text-center fs-4">{{ translate('Status') }}</th>
                @canany([Permission::WITHDRAW_ACCEPT->value, Permission::WITHDRAW_REJECT->value])
                    <th class="text-center fs-4">{{ translate('Attachment') }}</th>
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
                    <td class="text-center fs-5 fw-bolder">
                        {{ $request->updated_at->format('Y-m-d') }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        @switch($request?->status)
                            @case(2)
                                <span id="status-{{ $request->id }}-false" class="text-danger">
                                    <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                </span>
                            @break

                            @case(1)
                                <span class="text-success">
                                    <x-SVG.check-circle style="width: 1.4rem;height: 1.4rem" />
                                </span>
                            @break

                            @default
                        @endswitch
                    </td>
                    <td class="text-nowrap w-30 text-center">
                        @switch($request?->status)
                            @case(2)
                                <span id="status-{{ $request->id }}-false" class="text-danger">
                                    {{ $request->excuse }}
                                </span>
                            @break

                            @case(1)
                                <x-Image.show url="{{ asset('storage/' . $request->image) }}" />
                            @break

                            @default
                        @endswitch
                    </td>
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
