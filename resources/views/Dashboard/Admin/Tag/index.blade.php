@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Tags') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header d-flex flex-column align-items-start gap-2 mt-1">
                <h3 class="fw-bolder">{{ translate('All Tags') }}</h3>
                @can(Permission::TAG_CREATE->value)
                    <x-Button.add name="Add Tag" data-bs-toggle="modal" href="#addNewTag" />
                @endcan
            </div>
            <div class="card-body">
                <div id="page-data">
                    @include('Dashboard.Admin.Tag.Sections.indexTable', ['tags' => $tags])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection


@section('modal')
    <x-Modals.delete message="{{ 'are you sure to delete this tag?' }}" title="Delete" />
@endsection

@section('modalSecod')
    <div class="modal fade" id="addNewTag" aria-hidden="true" aria-labelledby="addNewTag" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalToggleLabel">{{ translate('Add Tag') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('dashboard.tags.store') }}" id="newTagForm">
                        @csrf
                        <x-inputs.Multi-Vertical.input label="Tag Name" name="name" placeholder="Tag Name"
                            inputId="tagName" size="col-12 mb-2" required />
                    </form>
                </div>
                <div class="modal-footer">
                    <x-Button.submit label="Save" type='button' onclick="addNewTag()" />
                    <button type="button" class="btn btn-outline-secondary fw-bolder fs-5 waves-effect"
                        data-bs-dismiss="modal" aria-label="Close">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('layout-scripts')
    <script>
        function addNewTag() {
            $('#newTagForm').submit();
        }

        function openDeleteModal(element) {
            $("#deleteFormModal").attr("action", $(element).attr('deleteUrl'));
        }
    </script>
@endpush
