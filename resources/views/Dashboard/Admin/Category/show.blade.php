@use('App\Enums\UserGender')
@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Show Category') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fs-2 text-bold">{{ translate('Show Category') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <x-inputs.h-input inputName="name" inputId="name" disabled="disabled" lable="Name"
                                placeholder="Category Name" value="{{ $category->name }}" />
                        </div>
                        <div class="row">
                            <x-inputs.h-input inputName="name_ar" inputId="name_ar" disabled="disabled"
                                lable="Name in arabic" placeholder="Category Name in arabic"
                                value="{{ getTranslation($category, 'name') }}" />
                        </div>

                        <x-inputs.h-input inputName="gender" inputId="gender" disabled="disabled" lable="Gender"
                            placeholder="Category Gender"
                            value="{{ translate(UserGender::formSelf($category->gender)) }}" />
                        <div class="row">

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-2 col-sm-3">
                                        <label class="col-form-label" for="Image">{{ translate('Image') }}</label>
                                    </div>
                                    <div class="col-10 col-sm-9">
                                        <input type="hidden" name="imageId" id="imageId" autocomplete="off"
                                            value="{{ $category?->attache?->upload?->id }}">
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <img src="{{ $category?->attache?->upload?->url }}"
                                                alt="{{ translate('No image found') }}" id="showImage" alt="Image"
                                                width="300" height="200" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="mt-4">{{ translate('Sub Categories') }}</h3>

                            @forelse ($category->children as $child)
                                <hr class="mb-4" />
                                <x-inputs.h-input-repeater lable="Name" disabled="disabled"
                                    placeholder="{{ translate('Category Name') }}" value="{{ $child->name }}" />
                                <x-inputs.h-input inputName="name_ar" inputId="name_ar" disabled="disabled"
                                    lable="Name in arabic" placeholder="Category Name in arabic"
                                    value="{{ getTranslation($child, 'name') }}" />

                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-2 col-sm-3">
                                            <label class="col-form-label" for="Image">{{ translate('Image') }}</label>
                                        </div>
                                        <div class="col-10 col-sm-9">
                                            <div class="d-flex align-items-center justify-content-center w-100">
                                                <img src="{{ $child?->attache?->upload?->url }}" id=""
                                                    alt="Image" width="300" height="200" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div colspan="6" class="text-center"> {{ translate('No Data') }} </div>
                            @endforelse

                            <div class="col-sm-9 offset-sm-3">
                                <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                    class="btn btn-primary me-1 waves-effect waves-float waves-light">{{ translate('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-Files.single inputFormId="imageId" showTagId="showImage" />
    </x-Content.normal>
@endsection


@push('layout-scripts')
    <script>
        $("#reset-btn").click(function(e) {
            e.preventDefault();
            $('#name').val('');
            $('#iamgeId').val('');
            $("#showImage").attr('src', 'https://via.placeholder.com/300x200.png/CCCCCC?text=Click+to+Add+Image');
        });
    </script>
@endpush
