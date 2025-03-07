@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('All Exports') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a id="download-all" onclick="bulkDownload()" class=" btn btn-larage btn-primary hidden">
                            {{ translate('Download') }}
                        </a>

                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.Export.sections.indexTable', ['exports' => $exports])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
@section('modal')
    <x-Modals.delete message="Are you sure to delete this File ?"></x-Modals.delete>
@endsection


@push('layout-scripts')
    <script>
        let checkedBoxes = [];
        let allButton = $("#export-all");
        allButton.click(function(e) {
            checkedBoxes = [];
            var btn = document.getElementById("export-all");

            let buttons = document.getElementsByName('export');
            buttons.forEach(element => {
                element.checked = btn.checked;
                if (btn.checked) {
                    checkedBoxes.push(element.id);
                } else {
                    checkedBoxes = [];
                }
            });

            if (checkedBoxes.length > 0) {
                $("#download-all").removeClass('hidden');
            } else {
                $("#download-all").addClass('hidden');
            }

        });

        checkBoxes = $('tbody [type="checkbox"]');

        $.map(checkBoxes, function(element, indexOrKey) {
            $(element).click(function(e) {
                if (element.checked) {
                    checkedBoxes.push(element.id);
                    if (checkedBoxes.length == checkBoxes.length) {
                        document.getElementById("export-all").checked = true;
                    }
                    $('#download-all').removeClass('hidden');
                } else {
                    checkedBoxes.splice(checkedBoxes.indexOf(element.id), 1);
                    document.getElementById("export-all").checked = false;
                    if (checkedBoxes.length == 0) {
                        $('#download-all').addClass('hidden');
                    }
                }

            });
        });

        function bulkDownload() {

            $.ajax({
                type: "POST",
                url: "{{ route('dashboard.exports.bulk.download') }}",
                data: {
                    files: checkedBoxes,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = response.url;

                    $.map(checkedBoxes, function(element, indexOrKey) {
                        let id = element.replace('export-', '');
                        $(`#download-${id}-false`).addClass('hidden');
                        $(`#download-${id}-true`).removeClass('hidden');

                    });
                }
            });

        }

        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }
    </script>
@endpush
