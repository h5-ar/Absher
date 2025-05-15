@use('App\Enums\Permission')
<div class="table-responsive p-2 pb-4 mb-2">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center fs-4">#</th>
                <th class="text-center fs-4">{{ translate('Order Number') }}</th>
                <th class="text-center fs-4">{{ translate('File Name') }}</th>
                @can(Permission::INVOICE_SHOW->value)
                    <th class="text-center fs-4">{{ translate('Actions') }}</th>
                @endcan

            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $key=>$invoice)
                <tr>
                    <td class="text-nowrap w-10 fs-5 fw-bolder text-center">
                        {{ ++$key + ($invoices->currentPage() - 1) * $invoices->perPage() }}</td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $invoice->order_number }}
                    </td>
                    <td class="text-center fs-5 fw-bolder">
                        {{ $invoice->order_number . '.pdf' }}
                    </td>
                    <td class="text-nowrap w-30 text-center">
                        @can(Permission::INVOICE_SHOW->value)
                            <a class="text-success" href="{{ $invoice->system_invoice_url }}" target="_blank">
                                <x-SVG.eye style="width: 1.4rem;height: 1.4rem" stroke='3' />
                            </a>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center fs-4 fw-bolder">
                        {{ translate('No Data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
<div class="px-1 mt-3">
    {{ $invoices->links('components.Pagination.ajax') }}
</div>
