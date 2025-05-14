@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('All Pages') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        @can(Permission::PAGE_CREATE->value)
                            <x-Button.add name="Add Page" route="{{ route('dashboard.pages.create') }}" />
                        @endcan
                    </div> --}}
                    <div class="card-body">
                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.Page.sections.indexTable', ['pages' => $pages])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
@section('modal')
    <x-Modals.delete message="Are you sure to delete this Page ?"></x-Modals.delete>
@endsection


@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
