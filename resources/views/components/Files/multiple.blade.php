@props([
    'fileType' => 'image',
    'inputFormId' => '',
    'showTagId' => '',
    'max' => 5,
    'repeater' => false,
    'repeaterName' => '',
])
@use('Carbon\Carbon')
@use('App\Models\Upload')

{{-- to use repeater functionality --}}

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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/extensions/ext-component-tree.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-file-manager.css') }}">
@endpush


@php
    $files = Upload::get();
    $modalId = $repeater === false ? 'modalFilesMulti' : 'modalFilesMulti' . $repeaterName;
    $labelledby = $repeater === false ? 'modalToggleLabel2' : 'modalToggleLabel2' . $repeaterName;
@endphp

@section('modalSecod')
    <div class="modal fade" id="{{ $modalId }}" aria-hidden="true" aria-labelledby="{{ $labelledby }}" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
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
                                    <div class="view-container">
                                        @forelse ($files as $key => $file)
                                            <div class="card file-manager-item file selected"
                                                onclick="selectImageMulti{{ $modalId }}('multiImageModal{{ $file->id }}','{{ $file->id }}')">
                                                <div class="form-check">
                                                    <input type="checkbox" value="{{ $file->id }}"
                                                        onclick="changeSelectMulti{{ $modalId }}(this)"
                                                        class="form-check-input" id="multiImageModal{{ $file->id }}"
                                                        autocomplete="off" />
                                                    <label class="form-check-label"
                                                        for="multiImageModal{{ $file->id }}"></label>
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
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close"
                        onclick="saveFileIds{{ $modalId }}()">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('layout-scripts')
    <script>
        @if ($repeater === false)
            const inputFormIdMulti = '{{ $inputFormId }}';
            let multiImagesId = [];

            // on initial select pervious images
            $('#{{ $modalId }}').on('show.bs.modal', function(event) {
                var values = $(`#${inputFormIdMulti}`).val();
                if (values.length > 0) {
                    multiImagesId = values.split(",");
                    let elements = $('#{{ $modalId }} .selected');
                    $.each(elements, function(indexInArray, element) {
                        var elementValue = $(element).children('.form-check').children(
                            'input[type="checkbox"]')[0]
                        if (multiImagesId.indexOf(elementValue.value) == -1) {
                            $(element).removeClass('selected');
                            elementValue.checked = false;
                        }
                    });
                }
            });

            // add or delete image from selected images
            function changeSelectMulti{{ $modalId }}(elem) {
                var max = '{{ $max }}'
                console.log(elem);
                if (multiImagesId.length + 1 <= max || multiImagesId.indexOf(elem.value) != -1) {
                    let elements = $('#{{ $modalId }} .selected');

                    var index = multiImagesId.indexOf(elem.value);

                    if (index != -1) {
                        multiImagesId.splice(index, 1)
                    } else {
                        multiImagesId.push(elem.value)
                    }

                    $.each(elements, function(indexInArray, element) {
                        var elementValue = $(element).children('.form-check').children('input[type="checkbox"]')[0]
                            .value

                        if (multiImagesId.indexOf(elementValue) == -1) {
                            $(element).removeClass('selected');
                        }
                    });

                    if (elem.checked) {
                        $(elem).closest('.file, .folder').addClass('selected');
                    }
                } else {
                    errorToast('{{ translate('You have reached maximum number of images') }}');
                }
            }

            function saveFileIds{{ $modalId }}() {
                $(`#${inputFormIdMulti}`).val(multiImagesId);
            }


            // click on image
            function selectImageMulti{{ $modalId }}(checkInputId, value) {
                var max = '{{ $max }}'
                if (multiImagesId.length + 1 <= max || multiImagesId.indexOf(value) != -1) {
                    var radioBtn = document.getElementById(checkInputId);
                    event.stopPropagation(); // Prevent event from bubbling up
                    radioBtn.click();
                } else {
                    errorToast('{{ translate('You have reached maximum number of images') }}');
                }
            }
        @else
            let multiImagesId{{ $modalId }} = [];
            let inputId{{ $modalId }} = '';
            let eventor{{ $modalId }} = undefined;

            $('#{{ $modalId }}').on('show.bs.modal', function(e) {
                multiImagesId{{ $modalId }} = []
                eventor = e.relatedTarget;
                var input = $(eventor).data('inputid');
                var values = $(`#${input}`).val();

                inputId{{ $modalId }} = input;
                if (values.length > 0) {
                    values = JSON.parse(values);
                    $.each(values, function(indexInArray, valueOfElement) {
                        values[indexInArray] = valueOfElement + ""
                    });
                    if (values == null) {
                        values = [];
                    }
                    multiImagesId{{ $modalId }} = values;
                }

                let elements = $('#{{ $modalId }} .selected');
                $.each(elements, function(indexInArray, element) {
                    var elementValue = $(element).children('.form-check').children(
                        'input[type="checkbox"]')[0]
                    if (multiImagesId{{ $modalId }}.indexOf(elementValue.value) == -1) {
                        $(element).removeClass('selected');
                        elementValue.checked = false;
                    }
                });

                $.each(multiImagesId{{ $modalId }}, function(indexInArray, valueid) {
                    var parent = $(`#multiImageModal${valueid}`).parent().parent().addClass('selected');
                    document.getElementById(`multiImageModal${valueid}`).checked = true;
                });

            });

            function selectImageMulti{{ $modalId }}(checkInputId, value) {
                var max = '{{ $max }}'
                if (multiImagesId{{ $modalId }}.length + 1 <= max ||
                    multiImagesId{{ $modalId }}.indexOf(value) != -1) {
                    var radioBtn = document.getElementById(checkInputId);
                    event.stopPropagation(); // Prevent event from bubbling up
                    radioBtn.click();
                } else {
                    errorToast('{{ translate('You have reached maximum number of images') }}');
                }
            }

            function saveFileIds{{ $modalId }}() {
                var inputId = inputId{{ $modalId }};
                var values = multiImagesId{{ $modalId }}.filter((id) => id != '' && id != "")
                var span = $(eventor).find('span')[0];
                span.innerText = '{{ translate('selected') }}' + `(${values.length})`
                if (values.length > 0) {
                    $(`#${inputId}`).val(JSON.stringify(values));
                } else {
                    $(`#${inputId}`).removeAttr('value');
                }
            }

            function changeSelectMulti{{ $modalId }}(elem) {
                var max = '{{ $max }}'

                if (multiImagesId{{ $modalId }}.length + 1 <= max || multiImagesId{{ $modalId }}.indexOf(elem
                        .value) != -1) {
                    let elements = $('#{{ $modalId }} .selected');

                    var index = multiImagesId{{ $modalId }}.indexOf(elem.value);

                    if (index != -1) {
                        multiImagesId{{ $modalId }}.splice(index, 1)
                    } else {
                        multiImagesId{{ $modalId }}.push(elem.value)
                    }

                    $.each(elements, function(indexInArray, element) {
                        var elementValue = $(element).children('.form-check').children('input[type="checkbox"]')[0]
                            .value

                        if (multiImagesId{{ $modalId }}.indexOf(elementValue) == -1) {
                            $(element).removeClass('selected');
                        }
                    });

                    if (elem.checked) {
                        $(elem).closest('.file, .folder').addClass('selected');
                    }
                } else {
                    errorToast('{{ translate('You have reached maximum number of images') }}');
                }
            }
        @endif


        // modal search
        const MultifilterInput{{ $modalId }} = $('#{{ $modalId }} .files-filter');
        const MultioResult{{ $modalId }} = $('#{{ $modalId }} .no-result');
        const MultiviewContainer{{ $modalId }} = $('#{{ $modalId }} .view-container');

        if (MultifilterInput{{ $modalId }}.length) {

            MultifilterInput{{ $modalId }}.on('keyup', function() {
                var value = $(this).val().toLowerCase();

                $('.file-manager-item').filter(function() {
                    var $this = $(this);

                    if (value.length) {
                        $this.closest('.file, .folder').toggle(-1 < $this.text().toLowerCase().indexOf(
                            value));
                        $.each(MultiviewContainer{{ $modalId }}, function() {
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
                        MultioResult{{ $modalId }}.addClass('d-none').removeClass('d-flex');
                    }
                });
            });
        }
    </script>
@endpush
