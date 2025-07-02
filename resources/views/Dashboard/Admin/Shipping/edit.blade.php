@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Edit Statut Shipment') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="createUserForm" action="{{ route('shipment.update', $shipment->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-2 col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder isRequired" for="gender">
                                    {{ translate('Statut Shipment') }}
                                </label>
                                <x-SVG.alert-circle description="Select Statut Shipment" />
                            </div>
                            <div class="col-10 col-sm-9">
                                <select class="select2 form-select" name="shipment_status" id="shipment_status">
                                    <option value="قيد المراجعة" @selected($shipment->shipment_status == 'قيد المراجعة')>
                                        قيد المراجعة
                                    </option>
                                    <option value="جاري الشحن" @selected($shipment->shipment_status == 'جاري الشحن')>
                                        جاري الشحن
                                    </option>
                                    <option value="تم الشحن" @selected($shipment->shipment_status == 'تم الشحن')>
                                        تم الشحن
                                    </option>
                                    <option value="تم الاستلام" @selected($shipment->shipment_status == 'تم الاستلام')>
                                        تم الاستلام
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <x-Button.submit />
                <x-Button.rest />
            </form>
        </div>
    </div>
</x-Content.normal>
@endsection
