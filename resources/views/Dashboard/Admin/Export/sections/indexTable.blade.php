@use('App\Enums\Permission')
<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4 d-flex">
                    <label class="container p-0">
                        <input type="checkbox" name="all" id="export-all" autocomplete="off">
                        <div class="checkmark"></div>
                    </label>
                </th>
                <th class="text-center fs-4">{{ translate('Seller') }}</th>
                <th class="text-center fs-4">{{ translate('File Name') }}</th>
                <th class="text-center fs-4">{{ translate('Downloaded') }}</th>
                <th class="text-center fs-4">{{ translate('Exported At') }}</th>
                @canany([Permission::EXPORT_DOWNLOAD->value, Permission::EXPORT_DELETE->value])
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($exports as $key=>$export)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        <input type="checkbox" name="export" autocomplete="off" id="export-{{ $export->id }}">
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $export?->seller?->user?->fullName }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $export?->name }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        @switch($export?->downloaded)
                            @case(0)
                                <span id="download-{{ $export->id }}-false" class="text-danger">
                                    <x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" stroke="3" />
                                </span>
                                <span id="download-{{ $export->id }}-true" class="text-success hidden">
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
                    <td class="text-center fs-5 fw-bolder">
                        {{ $export?->created_at->format('Y/m/d') }}
                    </td>
                    @canany([Permission::EXPORT_DOWNLOAD->value, Permission::EXPORT_DELETE->value])
                        <td class="text-nowrap w-30 text-center">
                            @can(Permission::EXPORT_DOWNLOAD->value)
                                <a id="download-{{ $export->id }}" onclick="downloadExcel(this)"
                                    url="{{ route('dashboard.exports.download', $export->id) }}" class="text-success">
                                    <x-SVG.download style="width: 1.4rem;height: 1.4rem" stroke='3' />
                                </a>
                            @endcan
                            @can(Permission::EXPORT_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.exports.delete', $export->id) }}" />
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
        {{ $exports->links('components.Pagination.ajax') }}
    </div>

    @push('layout-scripts')
        <script>
            function downloadExcel(elem) {
                event.preventDefault();
                let downlaodBtn = elem;
                url = $(elem).attr('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {

                        $(`#${elem.id}-false`).addClass('hidden');
                        $(`#${elem.id}-true`).removeClass('hidden');
                        window.location.href = response;
                        successToast("{{ translate('Exported successfully') }}");


                    }
                });
            }
        </script>
    @endpush
