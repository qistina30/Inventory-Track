<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [];

        for ($rack = 1; $rack <= 6; $rack++) {
            for ($row = 1; $row <= 5; $row++) {
                $locations[] = [
                    'rack' => $rack,
                    'row' => $row,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('locations')->insert($locations);
    }
}
