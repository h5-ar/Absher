<div class="table-responsive">
    <table class="table mb-0" id="reservationsTable">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('User Name') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Trip') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Seats Count') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservations as $key => $reservation)
            <tr data-reservation-id="{{ $reservation->id }}">
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($reservations->currentPage() - 1) * $reservations->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center user-name-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-user-id="{{ $reservation->user ? $reservation->user->id : '--' }}"
                    title="{{ translate('View User Details') }}">
                    {{ $reservation->user ? $reservation->user->first_name . ' ' . $reservation->user->last_name : '--' }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center trip-info-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-trip-id="{{ $reservation->trip_id }}"
                    title="{{ translate('View Trip Details') }}">
                    {{ $reservation->trip_id }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $reservation->count_seats }}
                </td>

                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.delete route="{{ route('reservation.delete', $reservation->id) }}" />
                    <button class="btn btn-link text-body  p-0 view-passengers-btn"
                        data-reservation-id="{{ $reservation->id }}"
                        title="{{ translate('View Passengers') }}">
                        <i class="fas fa-users"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center fs-4 fw-bolder py-4">{{ translate('No Data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
    {{ $reservations->links('components.Pagination.ajax') }}
</div>

<!-- Passengers Modal -->
<div class="modal fade" id="passengersModal" tabindex="-1" aria-labelledby="passengersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #65B1AB; color: white;">
                <h5 class="modal-title" id="passengersModalLabel">
                    <i class="fas fa-users me-2"></i>
                    <span id="modalUserName"></span>
                </h5>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">

                    <div>
                        <span class="fw-bold">{{ translate('Total Passengers:') }}</span>
                        <span id="modalPassengersCount" class="badge" style="background-color: #65B1AB; color: white;">0</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="passengersTable">
                        <thead class="table-light">
                            <tr>

                                <th class="text-nowrap w-10 fs-4 fw-bolder text-center">{{ translate('Reservation No') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('First Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Father Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Last Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('National Number') }}</th>

                                <th class="text-nowrap w-15 fs-4 fw-bolder text-center">{{ translate('Seat Number') }}</th>
                                <th class="text-nowrap w-15 fs-4 fw-bolder text-center">{{ translate('From') }}</th>
                                <th class="text-nowrap w-15 fs-4 fw-bolder text-center">{{ translate('To') }}</th>
                                <th class="text-nowrap w-15 fs-4 fw-bolder text-center">{{ translate('Actions') }}</th>
                            </tr>

                        </thead>
                        <tbody id="passengersTableBody">
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
        function loadPassengers(reservationId, userName) {
            $('#passengersTableBody').html(`
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </td>
            </tr>
            `);

            // تعيين اسم المستخدم في العنوان
            $('#modalUserName').text(userName);

            // جلب البيانات عبر AJAX
            $.ajax({
                url: "{{ route('reservation.passengers') }}",
                method: 'GET',
                data: {
                    reservation_id: reservationId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success && response.passengers && response.passengers.length > 0) {
                        let html = '';
                        response.passengers.forEach(passenger => {
                            html += `
                            <tr>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.reservation_id}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.first_name}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.father_name}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.last_name}</td>
                                                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.National_number}</td>

                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.seat_number}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.from}</td>
                                <td class="text-nowrap fs-5 fw-bolder text-center">${passenger.to}</td>
                                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                                   <x-Button.edit route="{{ route('passenger.edit', '') }}/${passenger.id}" />
                                   <x-Button.delete route="/passenger/delete/${passenger.id}/${passenger.reservation_id}" />
                            </tr>
                        `;
                        });
                        $('#passengersTableBody').html(html);
                        $('#modalPassengersCount').text(response.passengers.length);

                        if (response.trip_info) {
                            $('#modalTripInfo').html(`
                            ${response.trip_info.from} <i class="fas fa-arrow-right mx-2"></i> 
                            ${response.trip_info.to} (${response.trip_info.date})
                        `);
                        }
                    } else {
                        $('#passengersTableBody').html(`
                        <tr>
                            <td colspan="9"  class="text-center fs-4 fw-bolder py-4">
                                {{ translate('No Passengers Found For This Reservation') }}
                            </td>
                        </tr>
                    `);
                        $('#modalPassengersCount').text('0');
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

        $(document).on('click', '.view-passengers-btn', function() {
            const reservationId = $(this).data('reservation-id');
            const row = $(this).closest('tr');
            const userName = row.find('.user-name-btn').text().trim();
            console.log('User Name:', userName);
            loadPassengers(reservationId, userName);
            $('#passengersModal').modal('show');
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