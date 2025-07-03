@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Create Reservation') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form id="createForm" class="form form-horizontal" method="POST" action="{{ route('SAstore.reservation') }}">
                @csrf
                <x-inputs.h-company-select description="Select Company" onchange="filterTrips()" />
                <input type="hidden" name="trip_id" id="selectedTripId">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder" for="trip_select">{{ translate('Select Trip') }}</label>
                            </div>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" id="trip_select" class="form-control trip-input" readonly
                                        placeholder="{{ translate('Enter To Select Trip') }}" onclick="showTripsModal()">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label fs-5 fw-bolder" for="seats_count">{{ translate('Count Of Seats') }}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" inputName="count_seats" id="seatsCount" class="form-control"
                                    name="seats_count" placeholder="{{ translate('Enter number of passengers') }}">
                            </div>
                        </div>
                    </div>

                </div>

                <div id="passengersContainer"></div>
                <div class="col-sm-9 offset-sm-3">
                    <x-Button.submit />
                    <x-Button.rest />
                </div>
            </form>
        </div>
    </div>
</x-Content.normal>

<!-- Trips Modal -->
<div class="modal fade" id="tripsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #65B1AB; color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-route me-2"></i>
                    {{ translate('Available Trips') }}
                </h5>
            </div>
            <div class="card-body">
                <button id="quickTripsBtn" data-trip-type="quick" class="btn fw-bolder fs-5 me-1 waves-effect waves-float waves-light customSubmitButton active">
                    {{ translate('Quick Trips') }}
                </button>
                <button id="vehicleTripsBtn" data-trip-type="vehicle" class="btn fw-bolder fs-5 me-1 waves-effect waves-float waves-light customSubmitButton">
                    {{ translate('Vehicle Trips') }}
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('ID') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Price') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Bus') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Date') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Day') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('From') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('To') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Stations') }}</th>
                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tripTableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #65B1AB; color: white;" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> {{ translate('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedTripData = {};
    let currentPassengerCount = 0;

    function showTripsModal() {
        const companyId = document.getElementById('company').value;
        if (!companyId) {
            alert('الرجاء اختيار شركة أولاً');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('tripsModal'));
        modal.show();
        loadTrips('quick');
    }

    function loadTrips(type) {
        const companyId = document.getElementById('company').value;
        if (!companyId) {
            alert('الرجاء اختيار شركة أولاً');
            return;
        }

        const tripTableBody = document.getElementById('tripTableBody');
        tripTableBody.innerHTML = `
        <tr>
            <td colspan="9" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    `;

        fetch(`/SAtrips/filter?type=${type}&company=${companyId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => updateTripTable(data.trips))
            .catch(error => {
                console.error('Error:', error);
                tripTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-4 text-danger">
                        {{ translate('Failed to load trips') }}
                    </td>
                </tr>
            `;
            });
    }

    // دالة لتحديث جدول الرحلات
    function updateTripTable(trips) {
        const tripTableBody = document.getElementById('tripTableBody');
        tripTableBody.innerHTML = '';

        if (trips?.length > 0) {
            trips.forEach(trip => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center">${trip.id}</td>
                    <td class="text-center">${trip.price}</td>
                    <td class="text-center">${trip.bus_id}</td>
                    <td class="text-center">${trip.take_off_at}</td>
                    <td class="text-center">${trip.day}</td>
                    <td class="text-center">${trip.path?.from || '-'}</td>
                    <td class="text-center">${trip.path?.last_destination || '-'}</td>
                    <td class="text-center">
                        ${generateStationsPath(trip.path)}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary select-trip" 
                                data-id="${trip.id}"
                                data-path='${JSON.stringify(trip.path || {})}'
                                data-name="رحلة ${trip.id}">
                            {{ translate('Select') }}
                        </button>
                    </td>
                `;
                tripTableBody.appendChild(row);
            });
        }
    }

    // دالة مساعدة لإنشاء مسار المحطات
    function generateStationsPath(path) {
        if (!path) return '-';
        const stations = [path.to1, path.to2, path.to3, path.to4, path.to5].filter(Boolean);
        return stations.join(' → ') || '-';
    }

    // أحداث الأزرار
    document.addEventListener('DOMContentLoaded', function() {


        // أحداث أزرار نوع الرحلة
        document.getElementById('quickTripsBtn').addEventListener('click', () => loadTrips('quick'));
        document.getElementById('vehicleTripsBtn').addEventListener('click', () => loadTrips('vehicle'));

        // حدث اختيار رحلة
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('select-trip')) {
                const tripId = e.target.dataset.id;
                const tripPath = JSON.parse(e.target.dataset.path || '{}');

                selectedTripData = {
                    id: tripId,
                    path: tripPath
                };

                document.getElementById('selectedTripId').value = tripId;
                document.getElementById('trip_select').value = `رحلة ${tripId}`;

                // تحديث حقول الركاب إذا كانت موجودة
                if (currentPassengerCount > 0) {
                    updatePassengerFields();
                }

                bootstrap.Modal.getInstance(document.getElementById('tripsModal')).hide();
            }
        });

        // حدث تغيير عدد المقاعد
        document.getElementById('seatsCount').addEventListener('input', function() {
            currentPassengerCount = parseInt(this.value) || 0;
            updatePassengerFields();
        });
        document.getElementById('company').addEventListener('change', function() {
            // إفراغ حقول الرحلة عند تغيير الشركة
            document.getElementById('selectedTripId').value = '';
            document.getElementById('trip_select').value = '';
            document.getElementById('seatsCount').value = '';
            document.getElementById('passengersContainer').innerHTML = '';
            selectedTripData = {};
            currentPassengerCount = 0;

            // تحميل الرحلات الجديدة إذا كانت المودال مفتوحة
            if (document.getElementById('tripsModal').classList.contains('show')) {
                const activeBtn = document.querySelector('.customSubmitButton.active');
                if (activeBtn) {
                    loadTrips(activeBtn.dataset.tripType);
                }
            }
        });

    });

    // دالة لتحديث حقول الركاب
    function updatePassengerFields() {
        const container = document.getElementById('passengersContainer');

        if (!selectedTripData?.path) {
            alert('الرجاء اختيار رحلة أولاً');
            document.getElementById('seatsCount').value = '';
            container.innerHTML = '';
            return;
        }

        if (currentPassengerCount < 1 || currentPassengerCount > 30) {
            alert('عدد المقاعد يجب أن يكون بين 1 و 30');
            document.getElementById('seatsCount').value = '';
            container.innerHTML = '';
            return;
        }

        container.innerHTML = '';
        for (let i = 1; i <= currentPassengerCount; i++) {
            container.innerHTML += createPassengerCard(i, selectedTripData.path);
        }
    }

    // دالة لإنشاء بطاقة الراكب
    function createPassengerCard(passengerNumber, path) {
        return `
        <div class="card mb-3">
            <div class="card-header">الراكب ${passengerNumber}</div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <!-- حقول البيانات الأساسية -->
                        <x-inputs.h-input
                            inputName="passengers[${passengerNumber}][first_name]"
                            inputId="passenger_${passengerNumber}_first_name"
                            lable="{{ translate('First Name') }}"
                            type="text"
                            
                             />
              
                        <x-inputs.h-input
                            inputName="passengers[${passengerNumber}][father_name]"
                            inputId="passenger_${passengerNumber}_father_name"
                            lable="{{ translate('Father Name') }}"
                            type="text"
                           />
                            
                        <x-inputs.h-input
                            inputName="passengers[${passengerNumber}][last_name]"
                            inputId="passenger_${passengerNumber}_last_name"
                            lable="{{ translate('Last Name') }}"
                            type="text"
                            />
                    <x-inputs.h-input
                            inputName="passengers[${passengerNumber}][National_number]"
                            inputId="passenger_${passengerNumber}_National_number"
                            lable="{{ translate('National Number') }}"
                            type="text"
                            placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                                            />
                        <x-inputs.h-input
                            inputName="passengers[${passengerNumber}][seat_number]"
                            inputId="passenger_${passengerNumber}_seat_number"
                            lable="{{ translate('Seat Number') }}"
                            type="number"
                             />
                 
                      
                        
                        <!-- نقطة المغادرة -->
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label fs-5 fw-bolder" 
                                    for="DeparturePoint">
                                    {{ translate('Departure Point') }}</label>
                                </div>
                                <div class="col-sm-9">
                                    <select placeholder="{{ translate('Select Departure Point ') }}"
                                    autocomplete="off" class="select2 
                                    form-select rounded"
                                    name="passengers[${passengerNumber}][departure_point]">
                                                           <option value="from" selected>${path.from}</option>
                                   ${generateArrivalOptions(path)}
                                   </select>
                                </div>
                            </div>
                        </div>
                        <!-- نقطة الوصول -->
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label fs-5 fw-bolder" 
                                    for="ArrivalPoint">
                                    {{ translate('Arrival Point') }}</label>
                                </div>
                                <div class="col-sm-9">
                                    <select placeholder="{{ translate('Select Departure Point ') }}"
                                    autocomplete="off" class="select2 
                                    form-select rounded"
                                    name="passengers[${passengerNumber}][arrival_point]">
                                   <option value="${path.last_destination}" selected>${path.last_destination}</option>
                                   ${generateArrivalOptions(path)}
                                   </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    // دالة مساعدة لإنشاء خيارات الوصول
    function generateArrivalOptions(path) {
        let options = '';
        if (path.to1) options += `<option value="to1">${path.to1}</option>`;
        if (path.to2) options += `<option value="to2">${path.to2}</option>`;
        if (path.to3) options += `<option value="to3">${path.to3}</option>`;
        if (path.to4) options += `<option value="to4">${path.to4}</option>`;
        if (path.to5) options += `<option value="to5">${path.to5}</option>`;
        return options;
    }
</script>
@endpush