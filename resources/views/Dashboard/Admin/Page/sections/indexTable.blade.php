@use('App\Enums\Permission')

<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4">{{ translate('#') }}</th>
                <th class="text-center fs-4">{{ translate('Name') }}</th>
                <th class="text-center fs-4">{{ translate('Lang') }}</th>
                @canany([Permission::PAGE_UPDATE->value])
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($pages as $key=>$page)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ ++$key + ($pages->currentPage() - 1) * $pages->perPage() }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ translate($page->name) }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ translate($page->lang) }}</td>
                    @canany([Permission::PAGE_UPDATE->value])
                        <td class="text-nowrap w-30 text-center">
                            @can(Permission::PAGE_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.pages.edit', $page->id) }}" />
                            @endcan
                            {{-- @can(Permission::PAGE_DELETE->value)
                                <x-Button.delete route="{{ route('dashboard.pages.delete', $page->id) }}" />
                            @endcan --}}
                        </td>
                    @endcanany
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
<div class="px-1 mt-3">
    {{ $pages->links('components.Pagination.ajax') }}
</div>
