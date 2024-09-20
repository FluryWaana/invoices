<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<\App\Models\Invoice>
 */
class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer' => $this->customer,
            'number' => $this->number,
            'status' => $this->status,
            'sent_at' => $this->sent_at,
            'paid_at' => $this->paid_at,
            'total' => $this->invoiceLines->sum('amount'),
        ];
    }
}
