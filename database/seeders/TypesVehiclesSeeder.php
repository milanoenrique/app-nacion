<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TypesVehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_vehicles')->insert([
            'description' => 'starships',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ],
        [
            'description' => 'vehicles',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]
    );
    }
}
