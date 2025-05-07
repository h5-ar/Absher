@use('App\Enums\Permission')

<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Name') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Rate') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Comment') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Images') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Created At') }}</th>
                <th class="text-center fs-4" style="white-space: nowrap">{{ translate('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rates as $rate)
                <tr>
                    <td class="text-center fs-6 fw-bolder">
                        <a href="{{ route('dashboard.users.show', $rate->user->id) }}">
                            {{ $rate->user->fullName !== ' ' ? $rate->user->fullName : $rate->user->username }}
                        </a>

                    </td>
                    <td class="text-center fs-6 fw-bolder" style="white-space: nowrap">
                        @if ($rate->rate == 1)
                            <span style="color:#d93a27"><x-SVG.star fill='#d93a27' /></span>
                        @elseif($rate->rate == 2)
                            <span style="color:orange"><x-SVG.star fill='orange' /> <x-SVG.star
                                    fill='orange' /></span>
                        @elseif($rate->rate == 3)
                            <span style="color:#ddd365"><x-SVG.star fill='#ddd365' /> <x-SVG.star
                                    fill='#ddd365' /><x-SVG.star fill='#ddd365' /></span>
                        @elseif($rate->rate == 4)
                            <span style="color:yellowgreen"><x-SVG.star fill='yellowgreen' /> <x-SVG.star
                                    fill='yellowgreen' /> <x-SVG.star fill='yellowgreen' /> <x-SVG.star
                                    fill='yellowgreen' /> </span>
                        @elseif($rate->rate == 5)
                            <span style="color:green"><x-SVG.star fill='green' /> <x-SVG.star fill='green' />
                                <x-SVG.star fill='green' /> <x-SVG.star fill='green' /> <x-SVG.star
                                    fill='green' /></span>
                        @endif
                    </td>
                    <td class="text-center fs-6 fw-bolder">
                        {{ $rate->comment }}
                    </td>
                    <td class="text-center fs-6 fw-bolder">
                        <div class="d-flex gap-1 justify-content-around">
                            @foreach ($rate->attaches as $attache)
                                <div class="">
                                    <x-Image.show url="{{ $attache?->url }}" />
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center fs-6 ">
                        {{ $rate->updated_at->diffForHumans() }}
                    </td>
                    @can(Permission::PRODUCT_RATE_DELETE->value)
                        <td class="text-nowrap w-8 text-capitalize fs-5 fw-bold text-center">
                            <x-Button.delete route="{{ route('dashboard.products.rate.delete', $rate->id) }}" />
                        </td>
                    @endcan
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@section('modal')
    <x-Modals.delete message="Are You sure to delete this rate?" />
@endsection

@push('layout-scripts')
    <script>
        function openDeleteModal(element) {
            $("#deleteFormModal").attr("action", $(element).attr('deleteUrl'));
        }
    </script>
@endpush
