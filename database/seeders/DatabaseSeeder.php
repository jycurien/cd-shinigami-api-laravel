<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\CardOrder;
use App\Services\CheckSumCalculator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(CheckSumCalculator $checkSumCalculator)
    {
        for ($j = 0; $j < 3; $j++) {
            $order = CardOrder::factory()->create();
            for ($i = 0; $i < 100; $i++) {
                Card::factory()->create([
                    'center_code' => 124 + $j,
                    'card_code' => 100000 + $i,
                    'check_sum' => $checkSumCalculator->calculateCheckSum(124 + $j, 100000 + $i),
                    'card_order_id' => $order->id
                ]);
            }
        }


        // create one activated card
        $card = Card::factory()->create([
            'center_code' => 126,
            'card_code' => 100100,
            'check_sum' => $checkSumCalculator->calculateCheckSum(124, 100000 + $i),
            'activated_at' => new \DateTime()
        ]);
    }
}
