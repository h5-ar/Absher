@use('App\Enums\Permission')
<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-4">{{ translate('Name') }}</th>
                <th class="text-center fs-4">{{ translate('Arabic Name') }}</th>
                <th class="text-center fs-4">{{ translate('Category') }}</th>
                <th class="text-center fs-4">{{ translate('Brand') }}</th>
                <th class="text-center fs-4">{{ translate('Unit') }}</th>
                @can(Permission::PRODUCT_PUBLISH->value)
                    <th class="text-center fs-4">{{ translate('Published') }}</th>
                @endcan
                @can(Permission::PRODUCT_APPROVE->value)
                    <th class="text-center fs-4">{{ translate('Approved') }}</th>
                @endcan
                <th class="text-center fs-4">{{ translate('Archive') }}</th>
                @canany([Permission::PRODUCT_UPDATE->value, Permission::PRODUCT_DELETE->value])
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $product->name }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ getTranslation($product, 'name') }}</td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $product->category->name }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">{{ $product->brand->name }}</td>
                    <td class="text-center fs-5 fw-bolder">{{ $product->unit ?? '---' }}</td>
                    @can(Permission::PRODUCT_PUBLISH->value)
                        <td class=" fs-5 fw-bolder">
                            <x-inputs.switch name="published" id="published-{{ $product->id }}"
                                checked="{{ $product->published }}" class="form-check-input mx-auto"
                                onchange="updatePublished(this)" data-value="{{ $product->published }}"
                                data-productId="{{ $product->id }}" />
                        </td>
                    @endcan
                    @can(Permission::PRODUCT_APPROVE->value)
                        <td class="text-center fs-5 fw-bolder">
                            <x-inputs.switch name="approved" id="approved-{{ $product->id }}"
                                checked="{{ $product->approved }}" class="form-check-input mx-auto"
                                onchange="updateApproved(this)" data-value="{{ $product->approved }}"
                                data-productId="{{ $product->id }}" />
                        </td>
                    @endcan
                    <td class="text-center fs-5 fw-bolder">
                        <x-inputs.switch name="is_archived" checked="{{ $product->is_archived }}"
                            class="form-check-input mx-auto" onchange="updateArchive('{{ $product->id }}')"
                            data-value="{{ $product->is_archived }}" data-productId="{{ $product->id }}" />
                        <form action="{{ route('dashboard.products.toggle.archive', $product->id) }}"
                            id="archived-{{ $product->id }}" method="POST" hidden>
                            @csrf
                            @method('PUT')
                        </form>
                    </td>
                    @canany([Permission::PRODUCT_UPDATE->value, Permission::PRODUCT_DELETE->value])
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                    data-bs-toggle="dropdown">
                                    <x-SVG.more-vertical />
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can(Permission::PRODUCT_MODIFICATIONS->value)
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard.products.modifications', $product->sku) }}">
                                            <span class="me-50"><x-SVG.eye /> </span>
                                            <span>{{ translate('Edit History') }}</span>
                                        </a>
                                    @endcan
                                    @can(Permission::PRODUCT_RATES->value)
                                        <a class="dropdown-item" href="{{ route('dashboard.products.rates', $product->sku) }}">
                                            <span class="me-50"><x-SVG.star /> </span>
                                            <span>{{ translate('Rates') }}</span>
                                        </a>
                                    @endcan
                                    @can(Permission::PRODUCT_UPDATE->value)
                                        <a class="dropdown-item" href="{{ route('dashboard.products.edit', $product->sku) }}">
                                            <span class="me-50"><x-SVG.edit-2 /> </span>
                                            <span>{{ translate('Edit') }}</span>
                                        </a>
                                    @endcan
                                    @if (!$product->orders_count > 0)
                                        @can(Permission::PRODUCT_DELETE->value)
                                            <a class="dropdown-item"
                                                href="{{ route('dashboard.products.delete', $product->id) }}">
                                                <span class="me-50"><x-SVG.trash /></span>
                                                <span>{{ translate('Delete') }}</span>
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                            </div>
                        </td>
                    @endcanany
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1">
    {{ $products->links('components.Pagination.ajax') }}
</div>
