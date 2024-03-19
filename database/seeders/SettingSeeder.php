<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'identifier' => 'prize-total-number',
            'value' => 1000000,
        ]);
        Setting::create([
            'identifier' => 'spin-activity-interval',
            'value' => 1,
        ]);
        Setting::create([
            'identifier' => 'player-cache-ttl',
            'value' => 1,
        ]);
    }
}
