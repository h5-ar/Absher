@use('App\Enums\UserGender')
@use('App\Enums\Permission')
<div class="table-responsive">
    <table class="table mb-0 " style="padding: 0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-5 fs-4 text-center p-0" style="padding-right: 0px">#
                </th>
                <th scope="col" class="text-nowrap w-10 fs-4 text-center p-0">{{ translate('Image') }}
                </th>
                <th scope="col" class="text-nowrap w-10 fs-4 text-center p-0">{{ translate('Name') }}
                </th>
                <th scope="col" class="text-nowrap w-10 fs-4 text-center p-0">{{ translate('Username') }}
                </th>
                <th scope="col" class="text-nowrap w-10 fs-4 text-center p-0">{{ translate('Email') }}
                </th>
                <th scope="col" class="text-nowrap w-10 fs-4 text-center p-0">
                    {{ translate('Phone number') }}
                </th>
                @canany([Permission::USER_VIEW->value, Permission::USER_UPDATE->value, Permission::USER_BAN->value])
                    <th scope="col" class="text-nowrap fs-4 w-10 text-center p-0">{{ translate('Actions') }}
                    </th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $key => $user)
                <tr>
                    <td class="text-nowrap w-10 fs-5 text-center" style="padding-right: 0px; padding-left:0px">
                        {{ ++$key + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td class="text-nowrap  w-10 text-center">
                        <x-Image.show url="{{ asset($user?->attache?->upload?->url) }}" />
                    </td>
                    <td class="text-nowrap w-10 text-capitalize fw-bolder fs-5 text-center p-0">
                        {{ $user->fullName ?? '---' }}</td>
                    <td class="text-nowrap w-10 text-capitalize fw-bolder fs-5 text-center p-0">
                        {{ $user->username ?? '---' }}</td>
                    <td class="text-nowrap w-10 text-capitalize fw-bolder fs-5 text-center p-0">
                        {{ $user->email ?? '---' }}
                    </td>
                    <td class="text-nowrap w-10 text-capitalize fw-bolder fs-5 text-center p-0">
                        {{ $user->phone_number ?? '---' }}</td>
                    @canany([Permission::USER_VIEW->value, Permission::USER_UPDATE->value, Permission::USER_BAN->value])
                        <td class="text-nowrap w-10 text-capitalize fs-5 text-center p-0">
                            @can(Permission::USER_VIEW->value)
                                <x-Button.show route="{{ route('dashboard.users.show', $user->id) }}" />
                            @endcan
                            @can(Permission::USER_UPDATE->value)
                                <x-Button.edit route="{{ route('dashboard.users.edit', $user->id) }}" />
                            @endcan
                            @can(Permission::USER_BAN->value)
                                <a class="" onclick="openBanModal(this)" data-bs-toggle="modal" href="#deleteModal"
                                    data-message="{{ $user->is_blocked }}"
                                    deleteUrl="{{ route('dashboard.users.switchBan', $user->id) }}" role="button">
                                    @if ($user->is_blocked)
                                        <span class="text-danger"><x-SVG.x-circle style="width: 1.4rem;height: 1.4rem" /></span>
                                    @else
                                        <span class="text-success"><x-SVG.check-circle
                                                style="width: 1.4rem;height: 1.4rem" /></span>
                                    @endif
                                </a>
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $users->links('components.Pagination.ajax') }}
</div>
