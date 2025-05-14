@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Users') }}
@endsection
@use('App\Enums\UserGender')
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header">
                @can(Permission::USER_CREATE->value)
                    <x-Button.add name="Add User" route="{{ route('dashboard.users.create') }}" />
                @endcan
                <div class="col-md-1 col-sm-2 col-xs-2 col-1"></div>
                <div class="col-md-2 col-sm-6 col-xs-6 col-8">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6 col-4">
                            <label for="default-select" class="col-form-label fs-5">{{ translate('Gender') }}:</label>
                        </div>
                        <div class="col-md-8 col-sm-6 col-xs-6 col-6">
                            <select class="select2 form-select" name="gender" id="default-select">
                                <option value="{{ route('dashboard.users.index') }}" @selected(Route::is('dashboard.users.index'))>
                                    {{ translate('All') }}
                                </option>
                                @foreach (UserGender::cases() as $gender)
                                    <option value="{{ route('dashboard.users.indexByGender', $gender->value) }}"
                                        @selected(Route::current('dashboard.users.indexByGender') && Route::current()->parameters() ? Route::current()->parameters()['gender'] == $gender->value : false)>
                                        {{ translate("$gender->name User") }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.User.Sections.indexTable',['users'=>$users])
                </div>
            </div>
        </div>

    </x-Content.normal>
@endsection


@section('modal')
    <x-Modals.delete message="{{ 'test' }}" title="Excute"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        $(document).ready(function() {
            $('#default-select').on('change', function() {
                var selectedUrl = $(this).val();
                if (selectedUrl) {
                    window.location.href = selectedUrl;
                }
            });
        });

        function openBanModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));

            let status = $(elment).data('message');
            let title = status == 0 ? `{{ translate('Ban') }}` : `{{ translate('Remove ban') }}`;
            let message = status == 1 ? `{{ translate('Are you sure you want to remove ban on this user?') }}` :
                `{{ translate('Are you sure you want to ban this user?') }}`
            $('#message').text(message);
            $('#modal-title ,#exampleModalToggleLabel').text(title);

        }
    </script>
@endpush
