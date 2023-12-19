<?php

namespace Database\Seeders;

use App\Models\AssetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon; 

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $message = array(
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Dishwasher'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Fridge'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Freezer'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Under bench chiller'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Walk-in Chiller'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Walk-in Freezer'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Oven'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Ice Machine'),
            array('created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Kolb Oven')
        );
        foreach ($message as $key => $value) {
            AssetType::create([
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
                'name' => $value['name'],
            ]);
        }
    }
}
