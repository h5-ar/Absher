@extends('Dashboard.Layouts.adminLayout')

@section('title')
    @if (app()->getLocale() == 'en')
        {{ $offer->name }}
    @else
        {{ getTranslation($offer, 'name') }}
    @endif
@endsection

@section('content')
    <x-Content.normal>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate('Add Offer') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <x-inputs.Multi-Vertical.input value="{{ $offer->name }}" label="name" name="name"
                        placeholder="Offer Name" inputId="name" disabled />

                    <x-inputs.Multi-Vertical.input label="Name in Arabic" name="name_ar" placeholder="Offer Name In Arabic"
                        inputId="name_ar" value="{{ getTranslation($offer, 'name') }}" disabled />

                    <x-inputs.Multi-Vertical.input label="Value of promotion" name="value" inputmode="numeric"
                        value="{{ $offer->value }}" inputId="value" disabled />

                    <x-inputs.Multi-Vertical.select title="Offer Type" name="type" selectId="type" lable="Offer Type"
                        disabled>
                        <x-inputs.option lable="Gift" value="gift"
                            isSelected="{{ str()->lower($offer->type->name) }}" />
                        <x-inputs.option lable="Discount" value="discount"
                            isSelected="{{ str()->lower($offer->type->name) }}" />
                        <x-inputs.option lable="Percentage" value="percentage"
                            isSelected="{{ str()->lower($offer->type->name) }}" />
                    </x-inputs.Multi-Vertical.select>

                    <x-Date.picker-h name="start_date" dateId="start_date" label="Start Date"
                        value="{{ $offer->start_date }}" disabled />

                    <x-Date.picker-h name="end_date" dateId="end_date" label="End Date" value="{{ $offer->end_date }}"
                        disabled />
                </div>
            </div>
        </div>
        <!--  Divider  -->
        <div class="divider">
            <div class="divider-text text-muted">{{ translate('Products Offer') }}</div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="products-items">
                    @foreach ($offer->stocks as $stock)
                        <div class="row">
                            <x-inputs.Multi-Vertical.input
                                value="{{ translate('SKU') }}: {{ $stock->sku }} , {{ translate('Seller') }} : {{ $stock->seller->user->name }}"
                                label="name" placeholder="Offer Name" disabled size="col-6" />

                            <x-inputs.Multi-Vertical.input value="1" label="Quantity to Buy"
                                value="{{ $stock->pivot->quantity }}" placeholder="Offer Name" disabled size="col-6" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!--  End Divider  -->

        @if (count($offer->stocksGifts) > 0)
            <!--  Divider  -->
            <div class="divider">
                <div class="divider-text text-muted">{{ translate('Products Gifts') }}</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="products-gifts">
                        @foreach ($offer->stocksGifts as $stock)
                            <div class="row">
                                <x-inputs.Multi-Vertical.input
                                    value="{{ translate('SKU') }}: {{ $stock->sku }} , {{ translate('Seller') }} : {{ $stock->seller->user->name }}"
                                    label="name" placeholder="Offer Name" disabled size="col-6" />

                                <x-inputs.Multi-Vertical.input value="1" label="Quantity to Buy"
                                    value="{{ $stock->pivot->quantity }}" placeholder="Offer Name" disabled
                                    size="col-6" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--  End Divider  -->
        @endif


        <div class="col-12">
            <a href="{{ route('dashboard.offers.index') }}"
                class="btn btn-outline-secondary fw-bolder fs-5 waves-effect">{{ translate('Back') }}</a>
        </div>
    </x-Content.normal>
@endsection
