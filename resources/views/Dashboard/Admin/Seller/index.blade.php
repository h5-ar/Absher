@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Sellers') }}
@endsection

@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card shadow">
            <div class="card-header">
                @can(Permission::SELLER_CREATE->value)
                    <x-Button.add name="Add Seller" route="{{ route('dashboard.sellers.create') }}" />
                @endcan
                @can(Permission::ALL_SELLER_VIEW->value)
                    <div class="col-md-1 col-sm-2 col-xs-2 col-1"></div>
                    <div class="col-md-2 col-sm-6 col-xs-6 col-8">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-6 col-4">
                                <label for="default-select" class="col-form-label fs-4 fw-bolder">{{ translate('Type') }}:</label>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-6 col-6">
                                <select class="select2 form-select" name="gender" id="default-select">
                                    <option value="{{ route('dashboard.sellers.index') }}" @selected(Route::is('dashboard.sellers.index'))>
                                        {{ translate('All') }}
                                    </option>
                                    <option value="{{ route('dashboard.sellers.verified') }}" @selected(Route::is('dashboard.sellers.verified'))>
                                        {{ translate('Verified') }}
                                    </option>
                                    <option value="{{ route('dashboard.sellers.pending') }}" @selected(Route::is('dashboard.sellers.pending'))>
                                        {{ translate('Pending') }}
                                    </option>
                                    <option value="{{ route('dashboard.sellers.rejected') }}" @selected(Route::is('dashboard.sellers.rejected'))>
                                        {{ translate('Rejected ') }}
                                    </option>
                                    <option value="{{ route('dashboard.sellers.suspended') }}" @selected(Route::is('dashboard.sellers.suspended'))>
                                        {{ translate('Suspended') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.Seller.Sections.indexTable', ['sellers' => $sellers])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

@section('modal')
    <div class="modal fade" id="suspendModal" aria-hidden="true" aria-labelledby="suspendModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalToggleLabel">
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="message">
                    </h4>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="suspendFormModal">
                        @csrf
                        @method('put')
                        <button id="modal-title" class="btn btn-danger"></button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            aria-label="Close">{{ translate('Close') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        function openSuspendModal(elment) {
            $("#suspendFormModal").attr("action", $(elment).attr('suspendUrl'));
            let status = $(elment).data('message');
            let title = status == 1 ? `{{ translate('Suspend') }}` : `{{ translate('Release') }}`;
            let message = status == 1 ? `{{ translate('Are you sure you want to suspend this seller?') }}` :
                `{{ translate('Are you sure you want to release this seller?') }}`

            $('#message').text(message);
            $('#modal-title ,#exampleModalToggleLabel').text(title);
        }

        function submitForm(id) {
            $(`#${id}`).submit();
        }
    </script>
@endpush
