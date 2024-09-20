<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer' => 'required|string|max:255',
            'number' => 'required|string|max:50|unique:invoices,number',
            'status' => 'required|in:sent,late,paid,cancelled',
            'sent_at' => 'required|date',
            'paid_at' => 'nullable|date',
            'lines' => 'required|array|min:1',
            'lines.*.product' => 'required|string|max:255',
            'lines.*.amount' => 'required|numeric|min:0.01',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer.required' => 'Le nom du client est requis.',
            'number.required' => 'Le numéro de facture est requis.',
            'number.unique' => 'Ce numéro de facture existe déjà.',
            'status.required' => 'Le statut de la facture est requis.',
            'status.in' => 'Le statut de la facture doit être parmi: :values.',
            'sent_at.required' => 'La date d\'envoi est requise.',
            'lines.required' => 'Au moins une ligne de facture est requise.',
            'lines.*.product.required' => 'Le nom du produit est requis pour chaque ligne.',
            'lines.*.amount.required' => 'Le montant est requis pour chaque ligne.',
            'lines.*.amount.min' => 'Le montant doit être supérieur à 0 pour chaque ligne.',
        ];
    }
}
