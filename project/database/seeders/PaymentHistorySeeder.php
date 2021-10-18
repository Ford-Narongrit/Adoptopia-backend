<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentHistory;

class PaymentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentHistory = PaymentHistory::first();
        if(!$paymentHistory) {
            $paymentHistory = PaymentHistory::factory(10)->create();
        }
    }
}
