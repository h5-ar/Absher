@props([
    'description' => false,
])
@push('styles')
    <style>
        .image-reviwer {
            width: 25rem;
            height: 20rem;
        }

        @media only screen and (max-width: 600px) {
            .image-reviwer {
                width: 15rem;
                height: 10rem;
            }
        }
    </style>
@endpush

<div class="row">
    <div class="col-12">
        <div class="mb-1 row">
            <div class="col-2 col-sm-3">
                <label class="col-form-label fs-5 fw-bolder isRequired" for="Image">{{ translate('Image') }}</label>
                @if ($description)
                    <x-SVG.alert-circle description="{{ $description }}" />
                @endif
            </div>
            <div class="col-10 col-sm-9">
                <input type="hidden" name="imageId" id="imageId" autocomplete="off">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <img data-bs-toggle="modal" href="#modalFiles" role="button"
                        class="rounded rounded-3 image-reviwer shadow-bottom"
                        @if (app()->getLocale() == 'ar') src="{{ asset('app-assets/images/clickToAddAr.png') }}"
                        @else src="{{ asset('app-assets/images/clickToAddEn.png') }}" @endif
                        id="showImage" alt="Image" />
                </div>
            </div>
        </div>
    </div>
</div>
