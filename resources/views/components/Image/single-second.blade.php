<div class="col-md-6 col-12">
    <div class="mb-1">
        <label class="col-form-label" for="Image">{{ translate('Image') }}</label>

        <input type="hidden" name="imageId" id="imageId" autocomplete="off">

        <img data-bs-toggle="modal" href="#modalFiles" role="button" class="form-control"
            @if (app()->getLocale() == 'ar') src="{{ asset('app-assets/images/clickToAddAr.png') }}"
        @else src="{{ asset('app-assets/images/clickToAddEn.png') }}" @endif
            id="showImage" alt="Image" width="200" height="250" />

    </div>
</div>
