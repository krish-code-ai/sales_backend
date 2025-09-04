<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Books', 'Clothing', 'Sports', 'Toys', 'Furniture', 'Groceries'];
        $sources = ['Online', 'Store', 'Phone'];
        $locations = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami', 'San Francisco', 'Dallas'];
        $customers = [
            'Alice Smith', 'Bob Johnson', 'Carol Davis', 'David Wilson', 'Eve Martinez',
            'Frank Brown', 'Grace Taylor', 'Hank Anderson', 'Ivy Thomas', 'Jack White',
            'Kelly Harris', 'Leo Clark', 'Mia Lewis', 'Nina Walker', 'Oscar Hall',
            'Paul Allen', 'Queen Young', 'Ray King', 'Sara Scott', 'Tom Adams',
            'Uma Nelson', 'Victor Baker', 'Wendy Perez', 'Xavier Reed', 'Yara Campbell',
            'Zack Mitchell', 'Aaron Roberts', 'Bella Turner', 'Chris Phillips', 'Diana Parker',
            'Ethan Evans', 'Fiona Stewart', 'George Morris', 'Holly Rogers', 'Ian Cook',
            'Jenna Morgan', 'Kevin Peterson', 'Lara Cooper', 'Mason Flores', 'Nora Kelly',
            'Owen Bailey', 'Penny Rivera', 'Quinn Hughes', 'Ralph Price', 'Sophie Bennett',
            'Travis Wood', 'Ursula Barnes', 'Vince Ross', 'Will Murphy', 'Zoey Patterson',
        ];

        $data = [];

        for ($i = 1; $i <= 50; $i++) {
            $data[] = [
                'customer' => $customers[array_rand($customers)],
                'item_category' => $categories[array_rand($categories)],
                'order_date' => now()->subDays(rand(0, 30))->toDateString(),
                'source' => $sources[array_rand($sources)],
                'geo_location' => $locations[array_rand($locations)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('orders')->insert($data);
    }
}
