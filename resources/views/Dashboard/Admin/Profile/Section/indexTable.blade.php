@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-ecommerce.css') }}">
<style>
    body {
        padding-top: 1px;
        font-size: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="table-responsive">
    <div class="app-content content ecommerce-application mt-1">
        <div class="checkout-options">
            <div class="card">
                <div class="card-body">
                    <div class="coupons input-group input-group-merge d-flex justify-content-between">
                        <span class="fs-4 fw-bolder">
                            <div class="detail-title fw-bolder">
                            </div>
                        </span>

                    </div>
                    
                    <div class="price-details">
                        <h4 class="price-title">{{ translate('Information') }}:</h4>
                        <br>
                        <ul>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Name') }} :</div>
                                <div class="detail-amt discount-amt "> {{$user->name}}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Number') }} {{ translate('Phone') }}:</div>
                                <div class="detail-amt discount-amt "> {{ $user->phone }}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Email') }}:</div>
                                <div class="detail-amt">{{ $user->email}}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Username') }}:</div>
                                <div class="detail-amt">{{ $user->username}}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Password') }}:</div>
                                <div class="detail-amt">{{ $user->password}}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Description') }}:</div>
                                <div class="detail-amt">{{ $user->Description}}</div>
                            </li>
                            <hr>
                            <li class="price-detail">
                                <div class="detail-title fw-bolder">{{ translate('Manager') }}:</div>
                                <div class="detail-amt">{{ $user->manager->first_name}} {{ $user->manager->last_name}}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        <a href="{{ route('dashboard.profile.edit',$user->id)}}" class="btn btn-primary btn-next place-order col-sm-6 offset-sm-1"> {{ translate('Edit') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection