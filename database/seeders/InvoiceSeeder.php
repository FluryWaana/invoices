<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::factory(100)
            ->has(InvoiceLine::factory(10))
            ->create();
    }
}
