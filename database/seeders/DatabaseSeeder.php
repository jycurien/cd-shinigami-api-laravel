<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Services\CheckSumCalculator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        for ($i = 0; $i < 100; $i++) {
            Card::factory()->create([
                'center_code' => 124,
                'card_code' => 100000 + $i,
                'check_sum' => $checkSumCalculator->calculateCheckSum(124, 100000 + $i)
            ]);
        }
    }
}
