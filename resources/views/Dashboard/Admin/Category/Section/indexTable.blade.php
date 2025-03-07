@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                    {{ translate('Image') }}</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('Name') }}</th>
                @canany([Permission::CATEGORY_VIEW->value, Permission::CATEGORY_UPDATE->value,
                    Permission::CATEGORY_DELETE->value])
                    <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                        {{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $key => $category)
                <tr>
                    <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                        {{ ++$key + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                    <td class="text-nowrap w-20 text-center">
                        <x-Image.show url="{{ asset($category?->attache?->upload?->url) }}" />
                    </td>
                    <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                        {{ $category->name }}</td>
                    @canany([Permission::CATEGORY_VIEW->value, Permission::CATEGORY_UPDATE->value,
                        Permission::CATEGORY_DELETE->value])
                        <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                            @can(Permission::CATEGORY_VIEW->value)
                                <x-Button.show route="{{ route('dashboard.categories.show', $category->id) }}" />
                            @endcan
                            @can(Permission::CATEGORY_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.categories.edit', $category->id) }}" />
                            @endcan
                            @can(Permission::CATEGORY_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.categories.delete', $category->id) }}" />
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
<div class="px-1 mt-3">
    {{ $categories->links('components.Pagination.ajax') }}
</div>
