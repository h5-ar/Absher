@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Buses') }}
@endsection

@push('scripts')
<script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
@endpush

