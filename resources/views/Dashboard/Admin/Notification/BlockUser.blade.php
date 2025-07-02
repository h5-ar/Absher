@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Block User') }}
@endsection


@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST" action="{{ route('block') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="email" inputId="email" lable="User Email"
                                description="Enter User Email" placeholder="{{ translate('User Email') }}"
                                type="email" />
                            <x-inputs.Multi-Vertical.textarea name="reason" id="reason" label="Reason Of Block"
                                placeholder="{{ translate('Reason') }}" />
                        </div>
                        <div class="col-sm-9 offset-sm-3">
                            <x-Button.submit />
                            <x-Button.rest />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection