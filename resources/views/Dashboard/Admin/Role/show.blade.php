@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ $role->name . ' Role' }}
@endsection
@use('App\Enums\UserGender')
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">


            <div class="card-header">
                @can(Permission::USER_CREATE->value)
                    <div class="col-md-3 col-sm-4 col-xs-4 col-3">
                        <a class="btn btn-lg fs-3 fw-bolder customAddButton text-white" href="#editModal"
                            onclick="openAddModal(this)" data-bs-toggle="modal"
                            editUrl="{{ route('dashboard.roles.assign', $role->id) }}">{{ translate('Add User') }}</a>
                    </div>
                @endcan
            </div>

            <div class="card-body">
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
                                @can(Permission::ROLE_REMOVE->value)
                                    <th scope="col" class="text-nowrap fs-4 w-10 text-center p-0">{{ translate('Actions') }}
                                    </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($role->users as $key => $user)
                                <tr>
                                    <td class="text-nowrap w-10 fs-5 text-center"
                                        style="padding-right: 0px; padding-left:0px">
                                        {{ $loop->index + 1 }}</td>
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
                                    @can(Permission::ROLE_REMOVE->value)
                                        <td class="text-nowrap w-10 text-capitalize fs-5 text-center p-0">
                                            <a href="{{ route('dashboard.roles.remove', ['roleId' => $role->id, 'userId' => $user->id]) }}"
                                                class="text-danger">
                                                <x-SVG.user-minus />
                                            </a>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </x-Content.normal>
@endsection

@section('modal')
    <div class="modal fade text-start" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{ translate('Add users to this role') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editFormModal" method="POST">
                    @csrf
                    <div class="modal-body">

                        <label class="fs-4 fw-bolder">{{ translate('Username Or Name') }}:</label>

                        <x-inputs.h-multi-select-search size="col-12" view="w" name="users[]" isRequired="true"
                            placeholder="Click to add users" selectId="users"
                            ajaxRoute="{{ route('dashboard.roles.searchUsers', $role->name) }}" required>
                        </x-inputs.h-multi-select-search>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                            data-bs-dismiss="modal">{{ translate('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('layout-scripts')
    <script>
        function openAddModal(elment) {
            $("#editFormModal").attr("action", $(elment).attr('editUrl'));
        }
    </script>
@endpush

@push('styles')
    <style>
        .customAddButton {
            background-color: var(--nav-item-sub-selected-background);
            color: whitesmoke;
        }

        .customAddButton:hover {
            background-color: var(--side-background-color);
            color: whitesmoke;
        }
    </style>
@endpush
