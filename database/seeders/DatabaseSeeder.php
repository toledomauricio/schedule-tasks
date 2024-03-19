<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();

        $user->forceFill([
            "name" => "admin",
            "email" => "admin@admin.com.br",
            "password" => Hash::make("admin"),
        ]);

        $user->save();
    }
}
