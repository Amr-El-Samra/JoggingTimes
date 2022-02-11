<?php

namespace Database\Seeders;

use App\Models\JoggingTime;
use Illuminate\Database\Seeder;

class JoggingTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JoggingTime::create([
            'time_mins' => '15',
            'date' => '2022-2-7',
            'distance' => '3',
            'user_id' => '3'
        ]);

        JoggingTime::create([
            'time_mins' => '20',
            'date' => '2022-2-3',
            'distance' => '5',
            'user_id' => '3'
        ]);

        JoggingTime::create([
            'time_mins' => '25',
            'date' => '2022-2-10',
            'distance' => '4',
            'user_id' => '5'
        ]);

        JoggingTime::create([
            'time_mins' => '25',
            'date' => '2022-2-10',
            'distance' => '4',
            'user_id' => '3'
        ]);

        JoggingTime::create([
            'time_mins' => '25',
            'date' => '2022-2-13',
            'distance' => '4',
            'user_id' => '3'
        ]);
    }
}
