@props([
    'fileType' => 'image',
    'inputFormId' => '',
    'showTagId' => '',
    'assets'    => true
])
@use('Carbon\Carbon')
@use('App\Models\Upload')

@push('styles')
    <style>
        .custom-content-style {
            max-height: 65vh;
            overflow: auto !important;
        }

        .custom-content-style::-webkit-scrollbar {
            width: 0 !important;
        }
    </style>
    @if ($assets === true)
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css-rtl/plugins/extensions/ext-component-tree.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-file-manager.css') }}">
    @endif
@endpush


@php
    $files = Upload::get();
@endphp

@section('modal')
    <div class="modal fade" id="modalFiles" aria-hidden="true" aria-labelledby="modalFilesLable" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalToggleLabel">{{ translate('File Manager') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="file-manager-application">
                        <div class="content-area-wrapper container-xxl p-0">
                            <div class="file-manager-main-content">
                                <!-- search area start -->
                                <div class="file-manager-content-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="sidebar-toggle d-block d-xl-none float-start align-middle ms-1">
                                            <i data-feather="menu" class="font-medium-5"></i>
                                        </div>
                                        <div class="input-group input-group-merge shadow-none m-0 flex-grow-1">
                                            <span class="input-group-text border-0">
                                                <i data-feather="search"></i>
                                            </span>
                                            <input type="text" autocomplete="off"
                                                class="form-control files-filter border-0 bg-transparent"
                                                placeholder="{{ translate('Search') }}" />
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i data-feather="upload"
                                            class="font-medium-2 cursor-pointer d-sm-inline-block d-none me-50"
                                            id="singleFile" data-bs-toggle="modal" href="#upload" role="button"></i>
                                        <div class="btn-group view-toggle ms-50" role="group">
                                            <input type="radio" class="btn-check" name="view-btn-radio" data-view="grid"
                                                id="gridView" checked autocomplete="off" />
                                            <label class="btn btn-outline-primary p-50 btn-sm" for="gridView">
                                                <i data-feather="grid"></i>
                                            </label>
                                            <input type="radio" class="btn-check" name="view-btn-radio" data-view="list"
                                                id="listView" autocomplete="off" />
                                            <label class="btn btn-outline-primary p-50 btn-sm" for="listView">
                                                <i data-feather="list"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- search area ends here -->

                                <div class="file-manager-content-body custom-content-style">
                                    <!-- Files Container Starts -->
                                    <div class="view-container" id='view-container-single'>
                                        @forelse ($files as $key => $file)
                                            <div class="card file-manager-item file"
                                                onclick="selectImage('customCheck{{ $file->id }}')">
                                                <div class="form-check">
                                                    <input type="radio" value="{{ $file->id }}"
                                                        onchange="changeSelect(this)" name="radioFile"
                                                        imageUrl="{{ asset($file->url) }}" class="form-check-input"
                                                        id="customCheck{{ $file->id }}" autocomplete="off" />
                                                    <label class="form-check-label"
                                                        for="customCheck{{ $file->id }}"></label>
                                                </div>
                                                <div class="card-img-top file-logo-wrapper">
                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img src="{{ asset($file->url) }}" alt="Image" height="100vh"
                                                            width="100%" />
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="content-wrapper">
                                                        <p class="card-text file-name mb-0">{{ $file->name }}</p>
                                                        <p class="card-text file-date">
                                                            {{ Carbon::parse($file->created_at)->format('d F Y') }}</p>
                                                    </div>
                                                    <small
                                                        class="file-accessed text-muted">{{ Carbon::parse($file->created_at)->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="flex-grow-1 align-items-center no-result mb-3 fs-2">
                                                <i data-feather="alert-circle" class="me-50"></i>
                                                {{ translate('No Results') }}
                                            </div>
                                        @endforelse
                                        <div class="d-none flex-grow-1 align-items-center no-result mb-3">
                                            <i data-feather="alert-circle" class="me-50"></i>
                                            {{ translate('No Results') }}
                                        </div>
                                    </div>
                                    <!-- /Files Container Ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidenav-overlay"></div>
                    <div class="drag-target"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-wroning" data-bs-dismiss="modal" aria-label="Close"
                        id="close-file-manager">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" onclick="saveFileId()" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changeSelect(elem) {
            let elements = $('#modalFiles .selected');
            $.each(elements, function(indexInArray, valueOfElement) {
                if (valueOfElement.value != elem.value) {
                    $(valueOfElement).removeClass('selected');
                }
            });
            $(elem).closest('.file, .folder').addClass('selected');
        }

        function saveFileId() {
            let selectedFile = $($('#modalFiles .selected')[0]).find('.form-check-input')[0];
            const inputFormId = '{{ $inputFormId }}';
            const showTagId = '{{ $showTagId }}';
            $(`#${inputFormId}`).val(selectedFile?.value);
            $(`#${showTagId}`).attr('src', $(selectedFile).attr('imageUrl'));

        }

        function selectImage(checkInputId) {
            var radioBtn = document.getElementById(checkInputId);
            radioBtn.click();
        }

        const filterInput = $('#modalFiles .files-filter');
        const oResult = $('#modalFiles .no-result');
        const viewContainer = $('#modalFiles .view-container');

        if (filterInput.length) {

            filterInput.on('keyup', function() {
                var value = $(this).val().toLowerCase();

                $('.file-manager-item').filter(function() {
                    var $this = $(this);

                    if (value.length) {
                        $this.closest('.file, .folder').toggle(-1 < $this.text().toLowerCase().indexOf(
                            value));
                        $.each(viewContainer, function() {
                            var $this = $(this);
                            if ($this.find('.file:visible, .folder:visible').length === 0) {
                                $this.find('.no-result').removeClass('d-none').addClass(
                                    'd-flex');
                            } else {
                                $this.find('.no-result').addClass('d-none').removeClass(
                                    'd-flex');
                            }
                        });
                    } else {
                        $this.closest('.file, .folder').show();
                        noResult.addClass('d-none').removeClass('d-flex');
                    }
                });
            });
        }
    </script>
@endpush
