@use('App\Enums\Permission')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ translate('Add Product') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <x-inputs.Multi-Vertical.input label="name" name="name" placeholder="Product Name" inputId="name"
                description="Enter Product Name" required />

            <x-inputs.Multi-Vertical.input label="Name in Arabic" name="name_ar" placeholder="Product Name In Arabic"
                description="Enter Product Name In Arabic" inputId="name_ar" required />

            <x-inputs.Multi-Vertical.select title="Categories" name="sub_category_id" selectId="sub_category_id"
                description="Select Category" lable="Categories" required>
                @foreach ($categories as $category)
                    <optgroup label="{{ $category->name }}">
                        @foreach ($category->children as $subCategory)
                            @if ($subCategory->name == 'main')
                                <x-inputs.option lable2="{{ $category->name }}" value="{{ $subCategory->id }}" />
                            @else
                                <x-inputs.option lable2="{{ $subCategory->name }}" value="{{ $subCategory->id }}" />
                            @endif
                        @endforeach
                    </optgroup>
                @endforeach
            </x-inputs.Multi-Vertical.select>

            <x-inputs.Multi-Vertical.select title="Brands" name="brand_id" selectId="brand_id" lable="Brands"
                description="Select Brand" required>

                @foreach ($brands as $brand)
                    <x-inputs.option lable2="{{ $brand->name }}" value="{{ $brand->id }}" />
                @endforeach
            </x-inputs.Multi-Vertical.select>

            <x-inputs.Multi-Vertical.multi-select lable="Tags" name="tags[]" label="Tags"
                description="Pick Product Tags" placeholder="Click to add tags" selectId="tags" writeable='true'
                required>
                @foreach ($tags as $tag)
                    <x-inputs.option lable="{{ $tag }}" value="{{ $tag }}" />
                @endforeach
            </x-inputs.Multi-Vertical.multi-select>

            <x-inputs.Multi-Vertical.select title="Unit" name="unit" selectId="unit" lable="Unit"
                description="Select Unit">
                <x-inputs.option lable2="Kg" value="kg" />
                <x-inputs.option lable2="G" value="g" />
                <x-inputs.option lable2="L" value="l" />
                <x-inputs.option lable2="Ml" value="ml" />
            </x-inputs.Multi-Vertical.select>


            <x-inputs.Multi-Vertical.textarea label="Description" id="description"
                name="description">{{ old('description') }}</x-inputs.Multi-Vertical.textarea>


            <x-inputs.Multi-Vertical.textarea label="Description Arabic" id="description_ar" name="description_ar">
                {{ old('description_ar') }}</x-inputs.Multi-Vertical.textarea>


            <x-inputs.Multi-Vertical.input label="Min Quantity" name="min_quantity" inputmode="numeric"
                description="Enter Min Quantity To Show Product To User" onkeypress="return isNumberKey(event)"
                placeholder="Min Quantity To Display" inputId="min_quantity" required />

            <x-inputs.Multi-Vertical.input label="Max Quantity" name="max_quantity" inputId="max_quantity"
                description="Enter Max Quantity That User Can See" onkeypress="return isNumberKey(event)"
                placeholder="Max Quantity To Display" inputmode="numeric" required />

            <x-inputs.Multi-Vertical.input label="Min To Order" name="min_order" inputId="min_order" inputmode="numeric"
                description="Enter Min Number That User Can Order From This Product"
                onkeypress="return isNumberKey(event)" placeholder="Min Quantity To Order" required />

            <x-inputs.Multi-Vertical.input label="Max To Order" name="max_order" inputId="max_order" inputmode="numeric"
                description="Enter Max Number That User Can Order From This Product"
                onkeypress="return isNumberKey(event)" placeholder="Max Quantity To Order" required />


            <x-inputs.Multi-Vertical.input label="Recovery Duration (Days)" name="recovery_duration"
                description="Enter Number Of Days This Product Can Be Recovered" inputId="recovery_duration"
                inputmode="numeric" onkeypress="return isNumberKey(event)" placeholder="Recovery Duration" required
                disabled />


            <div class="col-md-6 col-12 mt-1">
                <div class="mb-1">
                    <div class="d-flex justify-content-around">
                        <div>
                            <x-inputs.switch name="recoverable" id="recoverable" label="Recoverable"
                                description="User Can Recover This Product" />

                        </div>
                        <div>
                            <x-inputs.switch name="recommended" id="recommended" label="recommended"
                                description="User See This Product As Recommended" />

                        </div>
                        @can(Permission::PRODUCT_FLASH->value)
                            <div>
                                <x-inputs.switch name="flash_deal" id="flash_deal" label="Flash Deal"
                                    description="User See This Product As Flash Deal" />
                            </div>
                        @endcan
                        @can(Permission::PRODUCT_PUBLISH->value)
                            <div>
                                <x-inputs.switch name="published" id="published" label="Publish"
                                    description="Publish The Product For Users" />
                            </div>
                        @endcan
                        <div>
                            <x-inputs.switch name="free_delivery" id="free-delivery" label="Free Delivery"
                                description="Free delivery for this product" />
                        </div>
                    </div>
                </div>
            </div>
            <x-Image.single description="Add Product Image" />

        </div>
    </div>
</div>
