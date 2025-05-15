@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Brand') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 fw-bolder text-bold">{{ translate('Add Brand') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.brands.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" isRequired="true"
                                    placeholder="{{ translate('Brand Name') }}" description="Enter Brand Name" />
                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    isRequired="true" placeholder="{{ translate('Brand Name in arabic') }}"
                                    description="Enter Brand Name In Arabic" />
                                <x-Image.single description="Add Brand Image" />
                                <div class="col-sm-9 offset-sm-3">
                                    <x-Button.submit onclick="validateInputs()" type="button" />
                                    <x-Button.rest />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-Files.single inputFormId="imageId" showTagId="showImage" />
    </x-Content.normal>
@endsection

