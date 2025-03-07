@extends('Dashboard.Layouts.adminLayout')
@use('Carbon\Carbon')


@section('title')
    {{ translate('File Manager') }}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/extensions/ext-component-tree.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-file-manager.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-file-manager.js') }}"></script>
@endpush

@section('content')
    <div class="app-content content file-manager-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="content-wrapper container-xxl p-0">
                <!-- file manager app content starts -->
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
                                <input type="text" class="form-control files-filter border-0 bg-transparent"
                                    placeholder="{{ translate("Search") }}" />
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <i data-feather="upload" class="font-medium-2 cursor-pointer d-sm-inline-block d-none me-50"
                                data-bs-toggle="modal" href="#upload" role="button"></i>
                            <div class="file-actions">
                                <i data-feather="trash" data-bs-toggle="modal" href="#delelteSelected" role="button"
                                    class="font-medium-2 cursor-pointer d-sm-inline-block d-none me-50"></i>
                            </div>
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

                    <div class="file-manager-content-body">
                        <!-- Files Container Starts -->
                        <div class="view-container">
                            @forelse ($files as $key => $file)
                                <div class="card file-manager-item file">
                                    <div class="form-check">
                                        <input type="checkbox" value="{{ $file->id }}" class="form-check-input"
                                            id="customCheck{{ $key }}" autocomplete="off" />
                                        <label class="form-check-label" for="customCheck{{ $key }}"></label>
                                    </div>
                                    <div class="card-img-top file-logo-wrapper" >
                                        <div class="d-flex align-items-center justify-content-center w-100"  >
                                            <img src="{{ asset($file->url) }}" alt="Image" height="100vh" width="100%" />
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
                                <div class="flex-grow-1 align-items-center no-result2 mb-3 fs-2">
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
                <!-- file manager app content ends -->
            </div>
            <form action="{{ route('dashboard.files.delete') }}" method="POST" id="deleteSelectedItems" hidden>
                @csrf
                <input hidden type="text" name="files" id="filesId">
            </form>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
@endsection

@section('modal')
    <div class="modal fade" id="delelteSelected" aria-hidden="true" aria-labelledby="delelteSelectedLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalToggleLabel">{{ translate('Delete') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4> {{ translate('Are you sure to delete the files ?') }} </h4>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button"
                        onclick="deleteFiles()">{{ translate('Delete') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload" aria-hidden="true" aria-labelledby="uploadLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="uploadLabel">{{ translate('Upload') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="file" class="my-pond" multiple autocomplete="off" name="image_uploader" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('layout-scripts')
    <script>
        function handelcheckedValue(elme) {
            var element = $(elme).parent().parent();
            var fileActions = $('.file-actions');
            if (!$(element).hasClass('selected')) {
                element.closest('.file, .folder').addClass('selected');
            } else {
                element.closest('.file, .folder').removeClass('selected');
            }
            if ($('.file-manager-item').find('.form-check-input:checked').length) {
                fileActions.addClass('show');
            } else {
                fileActions.removeClass('show');
            }
        }

        function deleteFiles() {
            let items = $('.file-manager-item');
            let files = [];
            $.each(items.find('.form-check-input:checked'), function(indexInArray, valueOfElement) {
                files = [...files, $(valueOfElement).val()];
            });
            $('#filesId').val(files);
            $("#deleteSelectedItems").submit();
        }

        $(function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            // Get a reference to the file input element
            const inputElement = document.getElementById('file');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement, {
                acceptedFileTypes: ['image/*'],
                allowMultipel: true,
                server: {
                    url: '{{ route('dashboard.files.store') }}',
                    method: 'POST',
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    process: {
                        onload: (response) => {
                            var file = JSON.parse(response).data;
                            $('.no-result').addClass('d-none');
                            $('.no-result2').addClass('d-none');

                            var newElemnt = ` <div class="card file-manager-item file">
                                    <div class="form-check">
                                        <input onchange="handelcheckedValue(this)" type="checkbox" value="${ file.id }" class="form-check-input"
                                            id="customCheck${ file.id }" autocomplete="off" />
                                        <label class="form-check-label" for="customCheck${ file.name }"></label>
                                    </div>
                                    <div class="card-img-top file-logo-wrapper">
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <img src="{{ asset('') }}${ file.url }" alt="Image" height="100vh" width="100%" />
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="content-wrapper">
                                            <p class="card-text file-name mb-0">${file.name}</p>
                                            <p class="card-text file-date">
                                                {{ Carbon::parse(now())->format('d F Y') }}</p>
                                        </div>
                                        <small
                                            class="file-accessed text-muted">{{ Carbon::parse(now())->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>`;
                            $(".view-container").append(newElemnt);

                        },
                    }
                },
            });

            pond.on('error', (error) => {
                toastr['error'](
                    '{{ translate('Please , check file type') }}',
                    '{{ translate('Error') }}', {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: true
                    }
                );
            });

        });
    </script>
@endpush
