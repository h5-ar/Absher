@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">{{ translate('Name') }}</th>
                @can(Permission::TAG_DELETE->value)
                    <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">{{ translate('Actions') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($tags as $key => $tag)
                <tr>
                    <td class="text-nowrap fs-5 fw-bolder w-10 text-center">
                        {{ ++$key + ($tags->currentPage() - 1) * $tags->perPage() }}</td>

                    <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">{{ $tag->name }}</td>


                    @can(Permission::TAG_DELETE->value)
                        <td class="text-nowrap w-30 text-center">
                            <x-Button.delete route="{{ route('dashboard.tags.destroy', $tag->id) }}" />
                        </td>
                    @endcan


                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $tags->links('components.Pagination.ajax') }}
</div>
