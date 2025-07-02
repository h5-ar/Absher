@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Subscription') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">

        <div class="card-body ">
            <div id="page-data">
                @include('DashboardSuperAdmin.SuperAdmin.Subscription.Section.indexTable',['subscriptions' => $subscriptions])

            </div>
        </div>
    </div>
</x-Content.normal>
@endsection
