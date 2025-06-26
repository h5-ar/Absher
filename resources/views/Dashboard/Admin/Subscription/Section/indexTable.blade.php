<div class="table-responsive">
    <table class="table mb-0" id="reservationsTable">
        <thead>
            <tr>
                <th scope="col" class="text-nowrap w-10 fs-4 fw-bolder text-center">#</th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('User ') }}
                </th>

                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Plan') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Count Trip') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Start') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('End') }}
                </th>
                <th scope="col" class="text-nowrap w-30 fs-4 fw-bolder text-center">
                    {{ translate('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $key => $subscription)
            <tr data-subscription-id="{{ $subscription->id }}">
                <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                    {{ ++$key + ($subscriptions->currentPage() - 1) * $subscriptions->perPage() }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center user-name-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-user-id="{{$subscription->user_id}}"
                    title="{{ translate('View User Details') }}">
                    {{ $subscription->user ? $subscription->user->first_name . ' ' . $subscription->user->last_name : '--' }}

                </td>

                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center plan-name-btn"
                    style="cursor: pointer; color: #65B1AB;"
                    data-plan-id="{{$subscription->plan_id}}"
                    title="{{ translate('View Plan Details') }}">
                    {{$subscription->plan->name}}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $subscription->rest_trips }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $subscription->start_at }}
                </td>
                <td class="text-nowrap w-50 text-capitalize fs-4 fw-bolder text-center">
                    {{ $subscription->end_at }}
                </td>
                <td class="text-nowrap w-30 text-capitalize fs-5 fw-bolder text-center">
                    <x-Button.delete route="{{ route('subscription.delete',$subscription->id) }}" />

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center fs-4 fw-bolder py-4">{{ translate('No Data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-1 mt-3">
    {{ $subscriptions->links('components.Pagination.ajax') }}
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

<!-- Plan Details Modal -->
<div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #65B1AB; color: white;">
                <h5 class="modal-title" id="planModalLabel">
                    <i class="fas fa-route me-2"></i>
                    {{ translate('Plan Details') }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="planDetailsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Number') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Name') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Trips Number') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Type Bus') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('Price') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('From') }}</th>
                                <th class="text-nowrap w-20 fs-4 fw-bolder text-center">{{ translate('To') }}</th>


                            </tr>
                        </thead>
                        <tbody id="planDetailsContent">
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
                        <td colspan="7" class="text-center fs-4 fw-bolder py-4">
                           ${ response.message }}}
                        </td>
                    </tr>
                `);
                    }
                },
                error: function() {
                    $('#userDetailsContent').html(`
                <tr>
                    <td colspan="7" class="text-center fs-4 fw-bolder py-4">
                        {{ translate('Error loading user details') }}
                    </td>
                </tr>
            `);
                }
            });
        }

        // دالة لجلب بيانات الخطة
        function loadPlanDetails(planId) {
            $('#planDetailsContent').html(`
            <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
            </tr>
            `);

            $.ajax({
                url: "{{ route('plan.details') }}",
                method: 'GET',
                data: {
                    plan_id: planId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        let html = `
                    <tr>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.id}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.name}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.trips_number}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.type_bus }</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.price}</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.form }</td>
                        <td class="text-nowrap fs-5 fw-bolder text-center">${response.plan.to }</td>
                        </tr>
                `;
                        $('#planDetailsContent').html(html);
                    } else {
                        $('#planDetailsContent').html(`
                    <tr>
                        <td colspan="7" class="text-center fs-4 fw-bolder py-4">
                           ${ response.message } || {{ translate('No User Data Found') }}
                        </td>
                    </tr>
                `);
                    }
                },
                error: function() {
                    $('#planDetailsContent').html(`
                <tr>
                    <td colspan="7" class="text-center fs-4 fw-bolder py-4">
                        {{ translate('Error loading user details') }}
                    </td>
                </tr>
            `);
                }
            });
        }

        $(document).on('click', '.user-name-btn', function(e) {
            e.preventDefault();
            const userId = $(this).data('user-id');
            loadUserDetails(userId);
            $('#userModal').modal('show');
        });

        $(document).on('click', '.plan-name-btn', function(e) {
            e.preventDefault();
            const planId = $(this).data('plan-id');
            loadPlanDetails(planId);
            $('#planModal').modal('show');
        });

    });
</script>
@endpush