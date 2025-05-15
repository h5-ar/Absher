@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Edit Variance') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 text-bold">{{ translate('Edit Variance') }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST"
                            action="{{ route('dashboard.variances.update', $variance->id) }}">
                            @csrf
                            @method('PUT')
                            <x-inputs.h-input readonly inputName="name" inputId="name" lable="Name" isRequired="true"
                                value="{{ $variance->name }}" placeholder="{{ translate('Variance Name') }}" />

                            <x-inputs.h-input inputName="name_ar" readonly inputId="name_ar" lable="Name in arabic"
                                value="{{ getTranslation($variance, 'name') }}"
                                placeholder="{{ translate('Variance Name in arabic') }}" />

                            <h3 class="mt-4">{{ translate('Add Values') }}</h3>
                            <hr class="mb-4" />

                            <div class="row">
                                <x-Repeater.container name="values">
                                    @forelse ($variance->history as $value)
                                        <x-Repeater.item-list>
                                            <x-inputs.h-input-repeater inputName="id" inputId="id" type='hidden'
                                                value="{{ $value->id }}" inputSize='d-none' />

                                            @if ($variance->name == 'color')
                                                <x-inputs.h-input-repeater type="color" inputName="value" inputId="value"
                                                    lable="Value" value="#{{ $value->value }}"
                                                    placeholder="{{ translate('Value') }}" isRequired="true" />
                                            @else
                                                <x-inputs.h-input-repeater inputName="value" inputId="value"
                                                    lable="Value" value="{{ $value->value }}"
                                                    placeholder="{{ translate('Value') }}" isRequired="true" />
                                            @endif
                                            {{-- <x-inputs.h-input-repeater inputName="value_ar" inputId="value_ar"
                                                value="{{ getTranslation($value, 'value') }}" lable="Value In Arabic"
                                                placeholder="{{ translate('Value In Arabic') }}" /> --}}

                                            <div class="col-12 d-flex justify-content-end mb-2">
                                                <button class="btn btn-sm btn-danger" onclick="deleteItem(this)"
                                                    type="button"><i data-feather="trash"></i></button>
                                            </div>
                                        </x-Repeater.item-list>
                                        @if ($loop->last)
                                            <x-Repeater.item-list defualt='true'>
                                                @if ($variance->name == 'color')
                                                    <x-inputs.h-input-repeater type="color" inputName="value"
                                                        inputId="value" lable="Value"
                                                        placeholder="{{ translate('Value') }}" isRequired="true" />
                                                @else
                                                    <x-inputs.h-input-repeater inputName="value" inputId="value"
                                                        lable="Value" placeholder="{{ translate('Value') }}"
                                                        isRequired="true" />
                                                @endif
                                                {{--
                                                <x-inputs.h-input-repeater inputName="value_ar" inputId="value_ar"
                                                    lable="Value In Arabic"
                                                    placeholder="{{ translate('Value In Arabic') }}" /> --}}

                                                <div class="col-12 d-flex justify-content-end mb-2">
                                                    <button class="btn btn-sm btn-danger" onclick="deleteItem(this)"
                                                        type="button"><i data-feather="trash"></i></button>
                                                </div>
                                            </x-Repeater.item-list>
                                        @endif
                                    @empty
                                        <x-Repeater.item-list defualt='true'>
                                            @if ($variance->name == 'color')
                                                <x-inputs.h-input-repeater type="color" inputName="value" inputId="value"
                                                    lable="Value" placeholder="{{ translate('Value') }}"
                                                    isRequired="true" />
                                            @else
                                                <x-inputs.h-input-repeater inputName="value" inputId="value" lable="Value"
                                                    placeholder="{{ translate('Value') }}" isRequired="true" />
                                            @endif

                                            {{-- <x-inputs.h-input-repeater inputName="value_ar" inputId="value_ar"
                                                lable="Value In Arabic" placeholder="{{ translate('Value In Arabic') }}" /> --}}

                                            <div class="col-12 d-flex justify-content-end mb-2">
                                                <button class="btn btn-sm btn-danger" onclick="deleteItem(this)"
                                                    type="button"><i data-feather="trash"></i></button>
                                            </div>
                                        </x-Repeater.item-list>
                                    @endforelse

                                </x-Repeater.container>
                            </div>
                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit />
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
