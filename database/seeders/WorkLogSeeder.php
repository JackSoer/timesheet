<?php

namespace Database\Seeders;

use App\Models\WorkLog;
use Illuminate\Database\Seeder;

class WorkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkLog::factory(10)->create();
    }
}
