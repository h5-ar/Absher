@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Coupons') }}
@endsection
@use('App\Enums\CouponType')
@use('App\Enums\DiscountType')
@use('App\Enums\Permission')
@section('content')
    <x-Content.normal>


        <div class="card">
            @can(Permission::COUPON_CREATE->value)
                <div class="card-header">
                    <x-Button.add name="Add Coupon" route="{{ route('dashboard.coupons.create') }}" />
                </div>
            @endcan
            <div class="card-body">

                <div id="page-data">
                    @include('Dashboard.Admin.Coupon.Sections.indexTable', ['coupons' => $coupons])
                </div>
            </div>
        </div>



    </x-Content.normal>
@endsection

@section('modal')
    <x-Modals.delete message="Are you sure to delete this coupon ?"></x-Modals.delete>
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
