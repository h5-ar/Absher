@props([
])
<div class="modal fade text-start" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">{{ translate("Edit Value Form") }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFormModal" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label>{{ translate('Value') }}</label>
                    <div class="mb-1">
                        <input type="text" name="value" id="value" placeholder="{{ translate('Value') }}" class="form-control" required/>
                    </div>

                    <label>{{ translate('Value in arabic') }}</label>
                    <div class="mb-1">
                        <input type="text" name="value_ar" id="value_ar" placeholder="{{ translate('Value in arabic') }}" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{ translate('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
