@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center ">{{ translate('Version') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center ">{{ translate('published') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Url') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('currency') }}</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('platform') }}</th>
                @can(Permission::VERSION_UPDATE->value)
                    <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Actions') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($versions as $key => $version)
                <tr>
                    <td class="text-nowrap fs-5 fw-bolder w-10 text-center">
                        {{ ++$key + ($versions->currentPage() - 1) * $versions->perPage() }}</td>
                    <td class="text-nowrap w-20 text-center">
                        {{ $version->version }}
                    </td>
                    <td class="text-nowrap w-20 text-capitalize fs-4 fw-bolder text-center">
                        @switch($version->published)
                            @case(0)
                                <span class="text-danger">
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
                    <td class="text-nowrap w-20 text-capitalize fs-4 fw-bolder text-center">{{ $version->url }}
                    <td class="text-nowrap w-20 text-capitalize fs-4 fw-bolder text-center">{{ $version->currency }}
                    <td class="text-nowrap w-20 text-capitalize fs-4 fw-bolder text-center">{{ $version->platform }}
                    </td>

                    @can(Permission::VERSION_UPDATE->value)
                        <td class="text-nowrap w-10 text-center">
                            <x-Button.edit route="{{ route('dashboard.versions.edit', $version->id) }}" />
                        </td>
                    @endcan

                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-1">
        {{ $versions->links('components.Pagination.ajax') }}
    </div>
