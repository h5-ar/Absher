@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Dashboard') }}
@endsection

@push('styles')
<style>
    .custom-content-style::-webkit-scrollbar {
        width: 0 !important;
    }

    .custom-content-style {
        scrollbar-width: none;
        /* For Firefox */
    }

    th,
    .sticky-top {
        background: white;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>
@endpush

@section('content')
    <div class="custom-content-style">
        <h1>Welcome</h1>
    </div>
@endsection
