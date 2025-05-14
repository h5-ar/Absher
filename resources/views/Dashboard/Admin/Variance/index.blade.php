@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Variances') }}
@endsection
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>
        {{-- <div class="content-header row">
            @can(Permission::VARIANCE_CREATE->value)
                <div class="col-2"> <x-Button.anchorButton class="btn-success" name="Add Variance"
                        route="{{ route('dashboard.variances.create') }}" /></div>
            @endcan
        </div> --}}
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Name') }}
                                </th>
                                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                                    {{ translate('Name in arabic') }}</th>
                                <th scope="col" class="text-nowrap w-20 fs-4 fw-bolder text-center">
                                    {{ translate('Count') }}</th>
                                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                                    {{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variances as $key => $variance)
                                <tr>
                                    <td class="text-nowrap w-10 fs-5 fw-bold text-center">
                                        {{ ++$key + ($variances->currentPage() - 1) * $variances->perPage() }}</td>
                                    <td class="text-nowrap w-40 fs-5 fw-bold text-center">
                                        {{ $variance->name }}
                                    </td>
                                    <td class="text-nowrap w-40 fs-5 fw-bold text-center">
                                        {{ getTranslation($variance, 'name') }}
                                    </td>
                                    <td class="text-nowrap w-20 fs-5 fw-bold text-capitalize fs-5 text-center">
                                        {{ $variance->history_count }}
                                    </td>
                                    <td class="text-nowrap w-30 fs-5 fw-bold text-capitalize fs-5 text-center">
                                        @can(Permission::VARIANCE_VIEW->value)
                                            <a href="{{ route('dashboard.variances.show', $variance->id) }}" class="">
                                                <span><x-SVG.eye style="height: 1.4rem;width:1.4rem" /></span>
                                            </a>
                                        @endcan
                                        {{-- @can(Permission::VARIANCE_UPDATE->value)
                                        <a href="{{ route('dashboard.variances.edit', $variance->id) }}"
                                            class="btn-success btn-rounded w-10 h-10 btn btn-md">{{ translate('Edit') }}</a>
                                    @endcan --}}
                                        {{-- @can(Permission::VARIANCE_DELETE->value)
                                            <a class="btn-danger btn-rounded w-10 h-10 btn btn-md" onclick="openDeleteModal(this)"
                                            data-bs-toggle="modal" href="#deleteModal"
                                            deleteUrl="{{ route('dashboard.variances.delete', $variance->id) }}"
                                            role="button">{{ translate('Delete') }}</a>
                                    @endcan --}}
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

            {{ $variances->links() }}
        </div>
    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this variance and all of it's values?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
