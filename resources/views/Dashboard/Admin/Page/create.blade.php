@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Add Page') }}
@endsection

@push('styles')
    {{-- <script src="{{ asset('assets/TEJQuery/jquery-te-1.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/TEJQuery/uncompressed/jquery-te-1.4.0.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/TEJQuery/jquery-te-1.4.0.css') }}"> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/translations/ar.js"></script>
@endpush
@push('styles')
    <style>
        body {
            width: 100%;
            overflow: hidden auto;
        }
    </style>
@endpush
@section('content')
    <x-Content.normal>
        <form id="createForm" class="form" method="POST" action="{{ route('dashboard.pages.store') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 fw-bolder text-bold">{{ translate('Add Page') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-inputs.Multi-Vertical.select selectId='name' name='name' title='Select page'
                            lable="Select page" isRequired="true">
                            <x-inputs.option value="about-us" lable="about us" />
                            <x-inputs.option value="privacy"  lable="privacy" />
                            <x-inputs.option value="FAQ"      lable="faq" />
                        </x-inputs.Multi-Vertical.select>

                        <x-inputs.Multi-Vertical.select selectId='lang' name='lang' title='Choose a language'
                            lable="Page Language" isRequired="true">
                            <x-inputs.option value="arabic" lable="Arabic" />
                            <x-inputs.option value="english" lable="English" />
                        </x-inputs.Multi-Vertical.select>
                    </div>
                    <h2 class="mb-0">{{ translate('Content') }}</h2>
                    <input id="content" name="content" type="hidden" />
                    <div>
                        <div id="editor">
                        </div>
                    </div>

                    <x-Button.submit class="mt-2" />
                    <x-Button.rest class="mt-2" />
                </div>
            </div>
            <!-- END: Content-->

        </form>
    </x-Content.normal>
@endsection

@push('layout-scripts')
    <script>
        let editor;
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['redo', 'undo', '|', 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList',
                    'blockQuote',
                    'outdent',
                    'indent',
                ],
                language: '{{ config('app.locale') }}'
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        $("#createForm").submit(function(e) {
            $("#content").val(editor.getData());
        });
    </script>
@endpush
