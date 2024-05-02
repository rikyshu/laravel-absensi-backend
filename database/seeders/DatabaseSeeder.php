<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Riky Shu',
            'email' => 'riky@fic16.com',
            'password' => Hash::make('123456789'),
        ]);

        //data dummy for company
        Company::create([
            'name' => 'PT. FIC16',
            'email' => 'fic16@codewithme.com',
            'address' => 'Jl.Bougenville Blok.S no 21, Bekasi Utara',
            'latitude' => '-7.747012',
            'longitude' => '110.343398',
            'radius_km' => '0.5',
            'time_in' => '08:00',
            'time_out' => '17:00',
        ]);

        $this->call([
            AttendanceSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
