<?php

namespace Tests\Feature\V1\Controllers;

use Database\Seeders\InvoiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_return_without_password(): void
    {
        $response = $this->getJson('/api/v1/invoices');

        $response->assertStatus(401);
    }

    public function test_index_return_paginated_invoices(): void
    {
        $this->seed(InvoiceSeeder::class);

        $response = $this->getJson('/api/v1/invoices?password=1234');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['customer', 'number', 'status', 'sent_at', 'paid_at', 'total'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_store_return_created_invoice(): void
    {
        $response = $this->postJson('/api/v1/invoices', [
            'customer' => 'John Doe',
            'number' => 'FA-2023-1001',
            'status' => 'sent',
            'sent_at' => '2021-01-01',
            'paid_at' => '2021-01-15',
            'lines' => [
                ['product' => 'Product 1', 'amount' => 100],
                ['product' => 'Product 2', 'amount' => 200],
            ],
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['customer', 'number', 'status', 'sent_at', 'paid_at', 'total'],
            ]);
    }

    public function test_store_return_error(): void
    {
        $response = $this->postJson('/api/v1/invoices', [
            'customer' => 'John Doe',
            'number' => 'FA-2023-1001',
            'status' => 'tata', // bad status
            'sent_at' => '2021-01-01',
            'paid_at' => '2021-01-15',
            'lines' => [
                ['product' => 'Product 1', 'amount' => 100],
                ['product' => 'Product 2', 'amount' => 200],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status']);
        $response->assertJsonFragment([
            'status' => ['Le statut de la facture doit être parmi: sent, late, paid, cancelled.'],
        ]);
    }
}
