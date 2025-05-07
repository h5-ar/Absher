@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Variance') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header row">
                @can(Permission::VARIANCE_UPDATE->value)
                    <div class="col-2"> <x-Button.anchorButton class="btn-success" name="Edit Variance"
                            route="{{ route('dashboard.variances.edit', $variance->id) }}" /></div>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-nowrap w-10 text-center">#</th>
                                <th scope="col" class="text-nowrap w-20 text-center">{{ translate('Value') }}</th>
                                <th scope="col" class="text-nowrap w-30 text-center">{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variance->history as $key => $body)
                                <tr>
                                    <td class="text-nowrap w-20 text-center">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="text-nowrap w-20 text-center">
                                        {{ $body->value }}
                                    </td>
                                    <td class="text-nowrap w-70 text-capitalize fs-5 text-center">
                                        {{-- @can(Permission::HISTORY_UPDATE->value)
                                            <a onclick="openEditModal(this)" data-value="{{ $body->value }}"
                                                data-value-ar="{{ getTranslation($body, 'value') }}"
                                                editUrl="{{ route('dashboard.histories.update', $body->id) }}"
                                                data-bs-toggle="modal" href="#editModal" class=""><x-SVG.edit /></a>
                                        @endcan --}}
                                        @can(Permission::HISTORY_DELETE->value)
                                            {{-- <a onclick="openDeleteModal(this)" data-bs-toggle="modal" href="#deleteModal"
                                                deleteUrl="{{ route('dashboard.histories.delete', $body->id) }}"
                                                role="button"></a> --}}
                                            <x-Button.delete route="{{ route('dashboard.histories.delete', $body->id) }}" />
                                        @endcan
                                    </td>

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
    <x-Modals.delete message="Are you sure to delete this value ?"></x-Modals.delete>
    {{-- <x-Modals.edit></x-Modals.edit> --}}
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }

        function openEditModal(elment) {
            $("#editFormModal").attr("action", $(elment).attr('editUrl'));
            $("#value").val($(elment).data('value'));
            $("#value_ar").val($(elment).data('value-ar'));
        }
    </script>
@endpush
