@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Settings') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bolder fw-bold">{{ translate('All Settings') }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.input onkeyup="onSearchOrderNumber(event)"
                                    inputId="orderNumber_search" label="Order Number" placeholder="Search By Order Number"
                                    size="col-12" />
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select title="Status" selectId="status_search" lable="Status"
                                    size="col-12" onchange="onSearchSelect(event,'status_search','status')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Pending" value="pending" translationFile="orders" />
                                    <x-inputs.option lable="Accepted" value="accepted" translationFile="orders" />
                                    <x-inputs.option lable="Rejected" value="rejected" translationFile="orders" />
                                    <x-inputs.option lable="Refund" value="refund" translationFile="orders" />
                                    <x-inputs.option lable="Completed" value="completed" translationFile="orders" />
                                    <x-inputs.option lable="Out For Delivery" value="out_for_delivery"
                                        translationFile="orders" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select lable="Payment Method" title="Filter By Payment Method"
                                    size="col-6 col-sm-12" selectId="paymentMethod_search"
                                    onchange="onSearchSelect(event,'paymentMethod_search','payment')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Syriatel Cash" value="syriatel_cash" />
                                    <x-inputs.option lable="MTN Cash" value="mtn_cash" />
                                    <x-inputs.option lable="Fatora" value="fatora" />
                                    <x-inputs.option lable="Cash on delivery" value="cash_on_delivery" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select selectId="shipping_search" lable="Shipping"
                                    title="Filter By Shipping Status" size="col-12"
                                    onchange="onSearchSelect(event,'shipping_search','shipping')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Delivered" value="delivered" translationFile="orders" />
                                    <x-inputs.option lable="Not delivered" value="on_delivery" translationFile="orders" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                        </div> --}}
                    </div>
                    <div id="page-data">

                        <div class="table-responsive p-2 pb-4 mb-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Key') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Value') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($settings as $setting)
                                        <tr>
                                            <td class="text-center fs-5 fw-bolder">{{ translate($setting->key) }}</td>
                                            <td class="text-center fs-5 fw-bolder">{{ $setting->value }}</td>
                                            <td class="text-center fs-5 fw-bolder">
                                                <a data-bs-toggle="modal" href="#updateModel" role="button"
                                                    onclick="updateSettings(this)"
                                                    data-url="{{ route('dashboard.settings.update', $setting->id) }}"
                                                    data-setting="{{ $setting }}"
                                                    data-key="{{ translate($setting->key) }}"
                                                    data-number="@if ($setting->key == 'paginate-count' || $setting->key == 'Shipping Cost' || $setting->key == 'Tax') yes
                                                    @else
                                                        no @endif"><x-SVG.edit /></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center fs-4 fw-bolder">
                                                {{ translate('No Data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-1">
                            {{ $settings->links('components.Pagination.ajax') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection


@section('modal')
    <div class="modal fade" id="updateModel" aria-hidden="true" aria-labelledby="updateModelAria" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalToggleLabel"> <span id="setting-name">
                        </span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateSettingsForm">
                        @csrf
                        @method('PUT')
                        <x-inputs.h-input inputName="value" inputId="value-update" lable="Value" isRequired="true" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-save" onclick="save()" class="btn btn-primary">{{ translate('Save') }}</button>
                    <button type="button" class="btn btn-outline-secondary fw-bolder fs-5 waves-effect"
                        data-bs-dismiss="modal" aria-label="Close">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('layout-scripts')
    <script>
        function updateSettings(element) {
            var setting = $(element).data('setting');
            const url = $(element).data('url');
            var isNumber = $(element).data('number');
            $('#value-update').val(setting?.value);
            console.log(isNumber);
            if (isNumber.includes('yes')) {
                $('#value-update').attr('onkeypress', 'return isNumberKey(event)');
            } else {
                $('#value-update').attr('onkeypress', 'return true');
            }
            $('#setting-name').text($(element).data('key'));

            $('#updateSettingsForm').attr('action', url);
        }

        function save() {
            $('#updateSettingsForm').submit();
        }
    </script>
@endpush
