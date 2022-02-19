<?php

namespace Database\Seeders;

use App\Models\CounterReading;
use Illuminate\Database\Seeder;

class CounterReadingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CounterReading::factory()->count(41)->create();
    }
}
