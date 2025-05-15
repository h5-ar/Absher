@use('App\Enums\BannerType')
@use('App\Enums\Permission')

<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Image') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-4 fw-bolder text-center">
                    {{ translate('Start date') }}
                </th>
                <th scope="col" class="text-nowrap w-15 fs-4 fw-bolder text-center">
                    {{ translate('End date') }}</th>
                <th scope="col" class="text-nowrap w-15 fs-4 fw-bolder text-center">
                    {{ translate('Type') }}
                </th>
                @canany([Permission::BANNER_UPDATE->value, Permission::BANNER_DELETE->value])
                    <th scope="col" class="text-nowrap w-15 fs-4 fw-bolder text-center">
                        {{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($banners as $key => $banner)
                <tr>
                    <td class="text-nowrap w-10 text-center">
                        {{ ++$key + ($banners->currentPage() - 1) * $banners->perPage() }}</td>
                    <td class="text-nowrap w-20 text-center">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <x-Image.show url="{{ asset($banner?->attache?->upload?->url) }}" />

                        </div>
                    </td>
                    <td class="text-nowrap w-15 text-capitalize fs-5 text-center">
                        {{ date('Y-m-d', strtotime($banner->start_date)) }}</td>
                    <td class="text-nowrap w-15 text-capitalize fs-5 text-center">
                        {{ date('Y-m-d', strtotime($banner->end_date)) }}</td>
                    <td class="text-wrap w-15 text-capitalize fs-5 text-center">
                        {{ translate(BannerType::formSelf($banner->type)) }}
                    </td>
                    @canany([Permission::BANNER_UPDATE->value, Permission::BANNER_DELETE->value])
                        <td class="text-nowrap w-8 text-capitalize fs-5 text-center">
                            @can(Permission::BANNER_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.banners.edit', $banner->id) }}" />
                            @endcan
                            @can(Permission::BANNER_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.banners.delete', $banner->id) }}" />
                            @endcan
                        </td>
                    @endcanany

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $banners->links('components.Pagination.ajax') }}
</div>
