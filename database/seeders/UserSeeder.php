<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Household;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a household
        $household = Household::create([
            'name' => 'Dev Household',
            'share_code' => Household::generateShareCode(),
        ]);

        // Create a default development user
        User::create([
            'name' => 'Dev User',
            'email' => 'dev@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'household_id' => $household->id,
        ]);
    }
}
