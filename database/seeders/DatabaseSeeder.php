<?php

namespace Database\Seeders;

use App\Http\Middleware\Customer;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            JobPrioritiesSeeder::class,
            User_Role_Seeder::class,
            CountriesSeeder::class,
            AssetTypeSeeder::class
        ]);

        // AssetType::factory()->count(10)->create();

        User::factory()
            ->count(10)
            ->has(Customers::factory())
            ->has(Asset::factory()
                ->count(1)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['asset_type_id' => AssetType::all()->random()],
                ))
            )
            ->create();
    }
}
