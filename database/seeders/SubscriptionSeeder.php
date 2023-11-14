<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Subscription::create([
            'name' => 'planA',
            'limit' => 20,
            'price' => 1800.00,
        ]);

        Subscription::create([
            'name' => 'planB',
            'limit' => 200,
            'price' => 2500.00,
        ]);

        Subscription::create([
            'name' => 'planC',
            'limit' => 500,
            'price' => 5000.00,
        ]);
    }
}
