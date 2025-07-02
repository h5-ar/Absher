@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Subscription') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card shadow">

        <div class="card-body ">
            <div id="page-data">
                @include('Dashboard.Admin.Subscription.Section.indexTable',['subscriptions' => $subscriptions])

            </div>
        </div>
    </div>
</x-Content.normal>
@endsection
