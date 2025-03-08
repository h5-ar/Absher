@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Add Trip') }}
@endsection

@push('scripts')
<script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
@endpush

@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add Trip') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('trip.store') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="price" inputId="price" lable="Price"
                                description="Enter Price Trip" placeholder="{{ translate('Price Trip') }}"
                                isRequired="true" />
                                
                        </div>

                        <div class="col-sm-9 offset-sm-3">
                            <x-Button.submit type="button" onclick="validateInputs()" />
                            <x-Button.rest />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection