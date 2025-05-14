@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Variance') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 text-bold">{{ translate('Add Variance') }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('dashboard.variances.store') }}">
                            @csrf
                            <div class="row">
                                <x-inputs.h-input inputName="name" inputId="name" lable="Name" isRequired="true"
                                    placeholder="{{ translate('Variance Name') }}" />
                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" lable="Name in arabic"
                                    placeholder="{{ translate('Variance Name in arabic') }}" />
                                </div>
                                <h3 class="mt-4">{{ translate('Add Values') }}</h3>
                                <hr class="mb-4" />

                                <div class="row">
                                    <x-Repeater.container name="values">
                                        <x-Repeater.item-list defualt='true'>
                                            <x-inputs.h-input-repeater inputName="value" inputId="value_ar" lable="Value"
                                            placeholder="{{ translate('Value') }}" isRequired="true" />

                                            <x-inputs.h-input-repeater inputName="value_ar" inputId="value_ar"
                                            lable="Value In Arabic"
                                            placeholder="{{ translate('Variance Name In Arabic') }}" />
                                            <div class="col-12 d-flex justify-content-end mb-2">
                                                <button class="btn btn-sm btn-danger" onclick="deleteItem(this)"
                                                type="button"><i data-feather="trash"></i></button>
                                            </div>
                                        </x-Repeater.item-list>

                                    </x-Repeater.container>
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
        <x-Files.single inputFormId="imageId" showTagId="showImage" />
    </x-Content.normal>
    @endsection


@push('layout-scripts')
    <script></script>
@endpush
