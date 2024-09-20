<?php

namespace App\Services\V1;

use App\Models\Invoice;
use App\Services\CrudService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService implements CrudService
{
    public function search(FormRequest $request): LengthAwarePaginator
    {
        $invoices = Invoice::query();

        $orderBy = $request->input('order-by', 'sent_at');
        $order = $request->input('order', 'desc');

        if ($orderBy === 'total') {
            $invoices->withSum('invoiceLines', 'amount')
                ->orderBy('invoice_lines_sum_amount', $order);
        } else {
            $invoices->orderBy($orderBy, $order);
        }

        return $invoices->paginate(self::PER_PAGE);
    }

    public function store(FormRequest $request): ?Invoice
    {
        DB::beginTransaction();

        try {
            $invoice = Invoice::query()->create($this->extractInvoiceData($request));
            $this->createInvoiceLines($request->input('lines'), $invoice);

            DB::commit();

            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();

            return null;
        }
    }

    private function extractInvoiceData(FormRequest $request): array
    {
        return $request->only(['customer', 'number', 'status', 'sent_at', 'paid_at']);
    }

    private function createInvoiceLines(array $lines, Invoice $invoice): void
    {
        $invoice->invoiceLines()->createMany($lines);
    }
}
