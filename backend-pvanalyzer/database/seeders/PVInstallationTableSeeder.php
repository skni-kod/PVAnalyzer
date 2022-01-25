<?php

namespace Database\Seeders;

use App\Models\PVInstallation;
use Illuminate\Database\Seeder;

class PVInstallationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PVInstallation::factory()->count(5)->create();
    }
}
