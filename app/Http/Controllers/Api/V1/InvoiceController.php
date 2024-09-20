<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\V1\SearchInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Services\V1\InvoiceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(SearchInvoiceRequest $request): AnonymousResourceCollection
    {
        $invoices = $this->invoiceService->search($request);

        return InvoiceResource::collection($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): InvoiceResource
    {
        $invoice = $this->invoiceService->store($request);

        abort_if(! $invoice, 500, 'Erreur lors de la création de la facture');

        return new InvoiceResource($invoice);
    }
}
