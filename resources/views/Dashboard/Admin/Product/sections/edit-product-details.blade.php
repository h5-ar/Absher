@use('App\Enums\Permission')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ translate('Add Product') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <x-inputs.Multi-Vertical.input label="name" name="name" placeholder="Product Name" inputId="name"
                value="{{ $product->name }}" required description="Enter Product Name" />

            <x-inputs.Multi-Vertical.input label="Name in Arabic" name="name_ar" placeholder="Product Name In Arabic"
                inputId="name_ar" required value="{{ getTranslation($product, 'name') }}"
                description="Enter Product Name In Arabic" />

            <x-inputs.Multi-Vertical.select title="Categories" name="sub_category_id" selectId="sub_category_id"
                description="Select Category" lable="Categories" required>
                @foreach ($categories as $category)
                    <optgroup label="{{ $category->name }}">
                        @foreach ($category->children as $subCategory)
                            @if ($subCategory->name == 'main')
                                <x-inputs.option lable2="{{ $category->name }}" value="{{ $subCategory->id }}"
                                    isSelected="{{ $product->category_id }}" />
                            @else
                                <x-inputs.option lable2="{{ $subCategory->name }}" value="{{ $subCategory->id }}"
                                    isSelected="{{ $product->category_id }}" />
                            @endif
                        @endforeach
                    </optgroup>
                @endforeach
            </x-inputs.Multi-Vertical.select>

            <x-inputs.Multi-Vertical.select title="Brands" name="brand_id" selectId="brand_id" lable="Brands" required
                description="Select Brand">
                @foreach ($brands as $brand)
                    <x-inputs.option lable2="{{ $brand->name }}" value="{{ $brand->id }}"
                        isSelected="{{ $product->brand_id }}" />
                @endforeach
            </x-inputs.Multi-Vertical.select>

            @php
                $diffTags = array_diff($product->tags, $tags->toArray());
            @endphp

            <x-inputs.Multi-Vertical.multi-select lable="Tags" name="tags[]" label="Tags"
                placeholder="Click to add tags" selectId="tags" writeable='true' required
                description="Pick Product Tags">
                @foreach ($tags as $key => $tag)
                    @if (in_array($tag, $product->tags))
                        <x-inputs.option lable="{{ $tag }}" value="{{ $tag }}" selected />
                    @else
                        <x-inputs.option lable="{{ $tag }}" value="{{ $tag }}" />
                    @endif
                @endforeach

                @foreach ($diffTags as $diffTag)
                    <x-inputs.option lable="{{ $diffTag }}" value="{{ $diffTag }}" selected />
                @endforeach
            </x-inputs.Multi-Vertical.multi-select>

            <x-inputs.Multi-Vertical.select title="Unit" name="unit" selectId="unit" lable="Unit"
                description="Select Unit">
                <x-inputs.option lable2="Kg" value="kg" isSelected="{{ $product->unit }}" />
                <x-inputs.option lable2="G" value="g" isSelected="{{ $product->unit }}" />
                <x-inputs.option lable2="L" value="l" isSelected="{{ $product->unit }}" />
                <x-inputs.option lable2="Ml" value="ml" isSelected="{{ $product->unit }}" />
            </x-inputs.Multi-Vertical.select>


            <x-inputs.Multi-Vertical.textarea label="Description" id="description"
                name="description">{{ $product->description }}</x-inputs.Multi-Vertical.textarea>


            <x-inputs.Multi-Vertical.textarea label="Description Arabic" id="description_ar" name="description_ar">
                {{ getTranslation($product, 'description') }}</x-inputs.Multi-Vertical.textarea>


            <x-inputs.Multi-Vertical.input label="Min Quantity" name="min_quantity" inputmode="numeric"
                value="{{ $product->min_quantity }}" onkeypress="return isNumberKey(event)"
                placeholder="Min Quantity To Display" inputId="min_quantity" required
                description="Enter Min Quantity To Show Product To User" />

            <x-inputs.Multi-Vertical.input label="Max Quantity" name="max_quantity" inputId="max_quantity"
                value="{{ $product->max_quantity }}" onkeypress="return isNumberKey(event)"
                placeholder="Max Quantity To Display" inputmode="numeric" required
                description="Enter Max Quantity That User Can See" />

            <x-inputs.Multi-Vertical.input label="Min To Order" name="min_order" inputId="min_order" inputmode="numeric"
                value="{{ $product->min_order }}" onkeypress="return isNumberKey(event)"
                placeholder="Min Quantity To Order" required
                description="Enter Min Number That User Can Order From This Product" />

            <x-inputs.Multi-Vertical.input label="Max To Order" name="max_order" inputId="max_order"
                inputmode="numeric" value="{{ $product->max_order }}" onkeypress="return isNumberKey(event)"
                placeholder="Max Quantity To Order" required
                description="Enter Max Number That User Can Order From This Product" />


            <x-inputs.Multi-Vertical.input label="Recovery Duration (Days)" name="recovery_duration"
                value="{{ $product->recovery_duration }}" inputId="recovery_duration" inputmode="numeric"
                onkeypress="return isNumberKey(event)" placeholder="Recovery Duration" required disabled
                description="Enter Number Of Days This Product Can Be Recovered" />


            <div class="col-md-6 col-12 mt-1">
                <div class="mb-1">
                    <div class="d-flex justify-content-around">
                        <div>
                            <x-inputs.switch name="recoverable" id="recoverable" label="Recoverable"
                                description="User Can Recover This Product" checked="{{ $product->recoverable }}" />
                        </div>
                        <div>
                            <x-inputs.switch name="recommended" id="recommended" label="recommended"
                                description="User See This Product As Recommended"
                                checked="{{ $product->recommended }}" />

                        </div>
                        @can(Permission::PRODUCT_FLASH->value)
                            <div>
                                <x-inputs.switch name="flash_deal" id="flash_deal" label="Flash Deal"
                                    description="User See This Product As Flash Deal"
                                    checked="{{ $product->flash_deal }}" />
                            </div>
                        @endcan
                        @can(Permission::PRODUCT_PUBLISH->value)
                            <div>
                                <x-inputs.switch name="published" id="published" label="Publish"
                                    description="Publish The Product For Users" checked="{{ $product->published }}" />
                            </div>
                        @endcan
                        <div>
                            <x-inputs.switch name="free_delivery" id="free-delivery" label="Free Delivery"
                                description="Free delivery for this product"
                                checked="{{ $product->free_delivery }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-1 row">
                    <div class="col-2 col-sm-3">
                        <label class="col-form-label fs-5 fw-bolder isRequired"
                            for="Image">{{ translate('Image') }}</label>
                        <x-SVG.alert-circle description="Add Product Image" />
                    </div>
                    <div class="col-10 col-sm-9">
                        <input type="hidden" name="imageId" id="imageId" autocomplete="off"
                            value="{{ $product?->attache?->upload?->id }}">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <img data-bs-toggle="modal" href="#modalFiles" role="button"
                                src="{{ asset($product?->attache?->upload?->url) }}"
                                alt="{{ translate('No image found') }}" id="showImage" alt="Image"
                                width="300" height="200" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
