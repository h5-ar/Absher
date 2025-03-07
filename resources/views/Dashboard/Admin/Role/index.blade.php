@extends('Dashboard.Layouts.adminLayout')
@section('title')
    {{ translate('Roles') }}
@endsection
@use('App\Enums\PermissionDescription')
@use('App\Enums\Permission')
@push('styles')
    <style>
        .custom-content-style {
            max-height: calc(100vh - 470px);
            overflow: auto !important;
        }

        .custom-content-style::-webkit-scrollbar {
            width: 4px !important;
        }

        .custom-content-style::-webkit-scrollbar-thumb {
            background-color: #7ABEB9;
            border-radius: 0% 20%;
        }
    </style>
@endpush
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <h3>{{ translate('Roles List') }}</h3>

                <!-- Role cards -->
                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $role->users_count }}
                                            {{ translate('user') }}</span>
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                            @foreach ($role->users as $user)
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" title="{{ $user->fullName }}"
                                                    class="avatar avatar-sm pull-up">
                                                    <img class="rounded-circle"
                                                        src="{{ asset($user?->attache?->upload?->url) }}" alt="Avatar" />
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                        <div class="role-heading">
                                            <h4 class="fw-bolder">{{ $role->name }}</h4>
                                            <a href="javascript:;" class="role-edit-modal" data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal" data-name='{{ ucfirst($role->name) }}'
                                                onclick="setEditModal(this)">
                                                <small class="fw-bolder">{{ translate('Edit Role') }}</small>
                                            </a>

                                        </div>
                                        <div>

                                            @can(Permission::ROLE_USERS_VIEW->value)
                                                <a href="{{ route('dashboard.roles.show', $role->id) }}"
                                                    style="color:var(--nav-item-sub-selected-background);justify-self:end">
                                                    <x-SVG.eye />
                                                </a>
                                            @endcan
                                            @can(Permission::ROLE_DELETE->value)
                                                <a href="{{ route('dashboard.roles.delete', $role->id) }}">
                                                    <i style="color: red" data-feather="trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="d-flex align-items-end justify-content-center h-100">
                                        <img src="{{ asset('assets/images/faq-illustrations.svg') }}"
                                            class="img-fluid mt-2" alt="Image" width="85" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body text-sm-end text-center ps-sm-0">
                                        <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                            class="stretched-link text-nowrap add-new-role">
                                            <span class="btn btn-primary mb-1">{{ translate('Add New Role') }}</span>
                                        </a>
                                        <p class="mb-0">{{ translate('Add role, if it does not exist') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- table -->
            <!-- Add Role Modal -->
            <div class="modal fade" style="max-height: 97vh; overflow: hidden;" id="addRoleModal" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5 pb-5">
                            <div class="text-center mb-4">
                                <h1 class="role-title">{{ translate('Add New Role') }}</h1>
                                <p>{{ translate('Set role permissions') }}</p>
                            </div>
                            <!-- Add role forms -->
                            <form id="addRoleForm" class="row" method="POST"
                                action="{{ route('dashboard.roles.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label" for="modalRoleName">{{ translate('Role Name') }}</label>
                                        <input type="text" required id="modalRoleName" name="name"
                                            class="form-control" placeholder="{{ translate('Enter role name') }}"
                                            tabindex="-1" data-msg="Please enter role name" />
                                    </div>
                                </div>
                                <h4 class="mt-2 pt-50">{{ translate('Role Permissions') }}</h4>
                                <div class="row row-cols-3 custom-content-style">
                                    <!-- Permission table -->
                                    {{-- <div class="d-flex justify-content-center" > --}}
                                    @foreach (PermissionDescription::cases() as $permission)
                                        <div class="mb-1 mr-1 d-flex flex-column justify-content-center">
                                            <x-inputs.switch labelStyle="font-size:12px;font-weight:bolder;" view="h"
                                                name="{{ $permission->name }}" translationFile="{{ 'permissions' }}"
                                                labelTitle="{{ $permission->value }}"
                                                label="{{ str($permission->name)->replace('_', ' ') }}" />
                                        </div>
                                    @endforeach
                                    {{-- </div> --}}
                                    <!-- Permission table -->
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" id="submit"
                                            class="btn btn-primary me-1">{{ translate('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            {{ translate('Discard') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add Role Modal -->

            <!-- Edit Role Modal -->
            <div class="modal fade" style="max-height: 97vh; overflow: hidden;" id="editRoleModal" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-role">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5 pb-5">
                            <div class="text-center mb-4">
                                <h1 class="role-title">{{ translate('Edit Role') }}</h1>
                                <p>{{ translate('Set role permissions') }}</p>
                            </div>
                            <!-- Edit role forms -->
                            <form id="editRoleForm" class="row" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label" for="EditRoleName">{{ translate('Role Name') }}</label>
                                        <input type="text" id="EditRoleName" required name="name"
                                            class="form-control" placeholder="{{ translate('Enter role name') }}"
                                            tabindex="-1" data-msg="Please enter role name" />
                                    </div>
                                </div>
                                <h4 class="mt-2 pt-50">{{ translate('Role Permissions') }}</h4>
                                <div class="row row-cols-3 custom-content-style">
                                    <!-- Permission table -->
                                    {{-- <div class="d-flex justify-content-center" > --}}
                                    @foreach (PermissionDescription::cases() as $permission)
                                        <div class="mb-1 mr-1 d-flex flex-column justify-content-center">
                                            <x-inputs.switch labelStyle="font-size:12px;font-weight:bolder;"
                                                view="h" name="{{ $permission->name }}"
                                                translationFile="{{ 'permissions' }}"
                                                data-name="{{ str()->lower($permission->name) }}"
                                                id="edit-{{ $permission->name }}" labelTitle="{{ $permission->value }}"
                                                label="{{ str($permission->name)->replace('_', ' ') }}" />
                                        </div>
                                    @endforeach
                                    {{-- </div> --}}
                                    <!-- Permission table -->
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" id="submit"
                                            class="btn btn-primary me-1">{{ translate('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            {{ translate('Discard') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!--/ Edit role form -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Edit Role Modal -->

        </div>
    </div>
    </div>
@endsection

@push('layout-scripts')
    <script>
        function setEditModal(elem) {
            let roleName = $(elem).data('name');
            $('#EditRoleName').val(roleName);
            let roles = @json($roles);
            let role = roles.find(role => role.name.toLowerCase() === roleName.toLowerCase());

            let url = "{{ route('dashboard.roles.update', ':id') }}";

            url = url.replace(':id', role.id);

            $('#editRoleForm').attr('action', url);

            let permissions = role.permissions;
            var allCheckBoxes = $('#editRoleModal input[type="checkbox"]');
            $.each(allCheckBoxes, function(indexInArray, valueOfElement) {
                if (permissions.find((value) => value.name == $(valueOfElement).data('name'))) {
                    valueOfElement.checked = true;
                } else {
                    valueOfElement.checked = false;
                }
            });

        }
    </script>
@endpush
