<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User_Role;

class User_Role_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $message = array(
            array('name' => 'admin'),
            array('name' => 'customer'),
            array('name' => 'technician'),
        );
        foreach ($message as $key => $value) {
            User_Role::create(['name' => $value['name']]);
        }
    }
}
