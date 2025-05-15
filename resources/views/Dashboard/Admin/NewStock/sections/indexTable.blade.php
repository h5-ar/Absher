@use('App\Enums\Permission')

<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4">{{ translate('#') }}</th>
                <th class="text-center fs-4">{{ translate('Image') }}</th>
                <th class="text-center fs-4">{{ translate('Seller') }}</th>
                <th class="text-center fs-4">{{ translate('Price') }}</th>
                <th class="text-center fs-4">{{ translate('Quantity') }}</th>
                <th class="text-center fs-4">{{ translate('Published') }}</th>
                @can(Permission::NEW_STOCK_PUBLISH->value)
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($stocks as $key=>$stock)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ ++$key + ($stocks->currentPage() - 1) * $stocks->perPage() }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        <x-Image.show url="{{ env('SELLER_DASHBOARD_URL') . 'storage/' . $stock->image }}" />
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $stock?->seller?->user?->fullName }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $stock?->purchase_price }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $stock?->quantity }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        @switch($stock?->published)
                            @case(0)
                                <span id="publish-{{ $stock->id }}-false" class="text-danger">
                                    <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                </span>
                                <span id="publish-{{ $stock->id }}-true" class="text-success hidden">
                                    <x-SVG.check-circle style="width: 1.4rem;height: 1.4rem" />
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
                    @can(Permission::NEW_STOCK_PUBLISH->value)
                        <td class="text-nowrap w-30 text-center">
                            <a id="publish-{{ $stock->id }}" onclick="publishStock(this)"
                                url="{{ route('dashboard.newStocks.publish', $stock->id) }}" class="text-success">
                                <x-SVG.send style="width: 1.4rem;height: 1.4rem" stroke='2' />
                            </a>
                        </td>
                    @endcan
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center fs-4 fw-bolder">
                            {{ translate('No Data') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-1 mt-3">
        {{ $stocks->links('components.Pagination.ajax') }}
    </div>
    @push('layout-scripts')
        <script>
            function publishStock(elem) {
                event.preventDefault();
                let downlaodBtn = elem;

                url = $(elem).attr('url');

                $.ajax({
                    type: "put",
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        successToast("{{ translate('Published successfully') }}");

                        $(`#${elem.id}-false`).addClass('hidden');
                        $(`#${elem.id}-true`).removeClass('hidden');
                    }
                });
            }
        </script>
    @endpush
