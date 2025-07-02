<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-50 fs-4 fw-bolder text-center">
                    {{ translate('User') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Name Recipient') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Phone Recipient') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('National Number Recipient') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Size') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Shipment Status') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Trip') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Action') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shipments as $key => $shipment)
            <tr>
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($shipments->currentPage() - 1) * $shipments->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center user-name-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-user-id="{{ $shipment->user->id  }}"
                    title="{{ translate('View User Details') }}">
                    {{ $shipment->user->first_name}} {{$shipment->user->last_name}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $shipment->name_user_to }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($shipment->phone_user_to	)}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $shipment->national_number_user_to }}
                </td>

                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($shipment->size)}}
                </td>

                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ translate($shipment->shipment_status	)}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center trip-info-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-trip-id="{{ $shipment->trip->id }}"
                    title="{{ translate('View Trip Details') }}">
                    {{ $shipment->trip_id}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    <button class="btn btn-link text-body  p-0 view-item-btn"
                        data-shipment-id="{{ $shipment->id }}"
                        title="{{ translate('View Item') }}">
                        <i data-feather='package'></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center fs-4 fw-bolder"> {{ translate('No Data') }} </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
    {{ $shipments->links('components.Pagination.ajax') }}
</div>


<!-- Item Modal -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <span class="fw-bold">{{ translate('Total Item:') }}</span>
                        <span id="modalItemCount" class="badge" style="background-color: #65B1AB; color: white;">0</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="itemTable">
                        <thead class="table-light">
                            <tr>

                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Shipment No') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Material Item') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Description Item') }}</th>
                            </tr>

                        </thead>
                        <tbody id="itemTableBody">
                            <!-- سيتم تعبئة البيانات هنا -->
                        </tbody>
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

<!-- User Details Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #65B1AB; color: white;">
                <h5 class="modal-title" id="userModalLabel">
                    <i class="fas fa-user me-2"></i>
                    {{ translate('User Details') }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="userDetailsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Id Number') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('First Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Last Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Email') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Phone') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Username') }}</th>

                            </tr>
                        </thead>
                        <tbody id="userDetailsContent">
                            <!-- سيتم تعبئة البيانات هنا -->
                        </tbody>
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

<!-- Trip Details Modal -->
<div class="modal fade" id="tripModal" tabindex="-1" aria-labelledby="tripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #65B1AB; color: white;">
                <h5 class="modal-title" id="tripModalLabel">
                    <i class="fas fa-route me-2"></i>
                    {{ translate('Trip Details') }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tripDetailsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Number') }}</th>

                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('From') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('To') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Date') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Day') }}</th>

                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Bus Number') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tripDetailsContent">
                            <!-- سيتم تعبئة البيانات هنا -->
                        </tbody>
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

@push('scripts')
<script>
    $(document).ready(function() {
        // دالة لجلب بيانات الركاب
        function loadItem(shipmentId) {
            $('#itemTableBody').html(`
            <tr>
                <td colspan="3" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
            `);

            // جلب البيانات عبر AJAX
            $.ajax({
                url: "{{ route('shipment.items') }}",
                method: 'GET',
                data: {
                    shipment_id: shipmentId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success && response.items && response.items.length > 0) {
                        let html = '';
                        response.items.forEach(item => {
                            html += `
                            <tr>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${item.shipping_id}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${item.material_value}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${item.description_item}</td>
                                   </tr>
                        `;
                        });
                        $('#itemTableBody').html(html);
                        $('#modalItemCount').text(response.items.length);


                    } else {
                        $('#itemTableBody').html(`
                        <tr>
                            <td colspan="3"  class="text-center fs-4 fw-bolder py-4">
                                {{ translate('No Item Found For This Shipment') }}
                            </td>
                        </tr>
                    `);
                        $('#modalItemCount').text('0');
                    }
                },

            });
        }

        // دالة لجلب بيانات المستخدم
        function loadUserDetails(userId) {
            $('#userDetailsContent').html(`
            <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
            </tr>
            `);

            $.ajax({
                url: "{{ route('user.details') }}",
                method: 'GET',
                data: {
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        let html = `
                    <tr>
                         <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.id}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.first_name}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.last_name}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.email || 'N/A'}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.phone || 'N/A'}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.user.username || 'N/A'}</td>

                        </tr>
                `;
                        $('#userDetailsContent').html(html);
                    } else {
                        $('#userDetailsContent').html(`
                    <tr>
                        <td colspan="6" class="text-center fs-4 fw-bolder py-4">
                            ${response.message} || {{ translate('No User Data Found') }}
                        </td>
                    </tr>
                `);
                    }
                },
                error: function() {
                    $('#userDetailsContent').html(`
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder py-4">
                        {{ translate('Error loading user details') }}
                    </td>
                </tr>
            `);
                }
            });
        }

        // دالة لجلب بيانات الرحلة
        function loadTripDetails(tripId) {
            $('#tripDetailsContent').html(`
            <tr>
            <td colspan="6" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
            </tr>
            `);

            $.ajax({
                url: "{{ route('trip.details') }}",
                method: 'GET',
                data: {
                    trip_id: tripId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        let tripHtml = `
                                   <tr>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.id}</td>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.from}</td>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.to}</td>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.date}</td>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.day}</td>
                                      <td class="text-nowrap fs-5 fw-bolder text-center">${response.trip.bus_number}</td>
                                    </tr>
                `;
                        $('#tripDetailsContent').html(tripHtml);
                    } else {
                        $('#tripDetailsContent').html(`
                    <tr>
                        <td colspan="6" class="text-center fs-4 fw-bolder py-4">
                            ${response.message} || {{ translate('No Trip Data Found') }}
                        </td>
                    </tr>
                `);
                    }
                },
                error: function() {
                    $('#tripDetailsContent').html(`
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder py-4">
                        {{ translate('Error loading trip details') }}
                    </td>
                </tr>
            `);
                }
            });
        }

        $(document).on('click', '.view-item-btn', function() {
            const shipmentId = $(this).data('shipment-id');
            loadItem(shipmentId);
            $('#itemModal').modal('show');
        });
        $(document).on('click', '.user-name-btn', function() {
            const userId = $(this).data('user-id');
            loadUserDetails(userId);
            $('#userModal').modal('show');
        });
        $(document).on('click', '.trip-info-btn', function() {
            const tripId = $(this).data('trip-id');
            loadTripDetails(tripId);
            $('#tripModal').modal('show');
        });
    });
</script>
@endpush