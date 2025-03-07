@props([
    'message' => '',
    'title' => 'Delete',
])
<div class="modal fade" id="deleteModal" aria-hidden="true" aria-labelledby="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalToggleLabel">{{ translate($title) }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="message" class="modal-body">
                <h4> {{ translate($message) }} </h4>
            </div>
            <div class="modal-footer">
                <form  method="POST" id="deleteFormModal">
                    @csrf
                    @method('DELETE')
                    <button id="modal-title" class="btn btn-danger" >{{ translate($title) }}</button>
                    <button type="button" class="btn btn-outline-secondary fw-bolder fs-5 waves-effect" data-bs-dismiss="modal"
                        aria-label="Close">{{ translate('Close') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
