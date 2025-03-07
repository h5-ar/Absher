@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center ">{{ translate('Image') }}</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">{{ translate('Name') }}</th>
                @canany([Permission::BRAND_UPDATE->value, Permission::BRAND_DELETE->value])
                    <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($brands as $key => $brand)
                <tr>
                    <td class="text-nowrap fs-5 fw-bolder w-10 text-center">
                        {{ ++$key + ($brands->currentPage() - 1) * $brands->perPage() }}</td>
                    <td class="text-nowrap w-20 text-center">
                        <x-Image.show url="{{ asset($brand?->attache?->upload?->url) }}" />
                    </td>
                    <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">{{ $brand->name }}</td>

                    @canany([Permission::BRAND_UPDATE->value, Permission::BRAND_DELETE->value])
                        <td class="text-nowrap w-30 text-center">
                            @can(Permission::BRAND_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.brands.edit', $brand->id) }}" />
                            @endcan
                            @can(Permission::BRAND_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.brands.delete', $brand->id) }}" />
                            @endcan
                        </td>
                    @endcanany

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $brands->links('components.Pagination.ajax') }}
</div>
