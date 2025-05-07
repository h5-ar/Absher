@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('edit Page') }}
@endsection

@push('styles')
    {{-- <script src="{{ asset('assets/TEJQuery/jquery-te-1.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/TEJQuery/uncompressed/jquery-te-1.4.0.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/TEJQuery/jquery-te-1.4.0.css') }}"> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/translations/ar.js"></script>
@endpush

@section('content')
    <x-Content.normal>
        <form id="createForm" class="form" method="POST" action="{{ route('dashboard.pages.update', $page->id) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 fw-bolder text-bold">{{ translate('edit Page') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-inputs.Multi-Vertical.input value="{{ translate($page->name) }}" label="Page Name" inputId='name'
                            placeholder='Page Name' isRequired="true" readonly />

                        <x-inputs.Multi-Vertical.input value="{{ translate($page->lang) }}" label="Page Language"
                            placeholder='Page Language' isRequired="true" readonly />

                        <input type="hidden" name="name" value="{{ $page->name }}">
                        <input type="hidden" name="lang" value="{{ $page->lang }}">
                    </div>
                    <h2 class="mb-0">{{ translate('Content') }}</h2>
                    <input id="content" name="content" type="hidden" />
                    <div id="editor">
                    </div>

                    <x-Button.submit class="mt-2" />
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
        $(document).ready(function() {
            editor.setData('{!! $page->content !!}');
        });
        $("#createForm").submit(function(e) {
            $("#content").val(editor.getData());
        });
    </script>
@endpush
