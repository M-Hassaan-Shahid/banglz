<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
  if (!User::where('email', 'admin@admin.com')->exists()) {
    User::updateOrCreate(
        ['email' => 'admin@admin.com'], // Condition to check
        [
            'name'     => 'Admin',
            'type'     => 'admin',
            'password' => Hash::make('admin'), // Change to a secure password
        ]
    );
}
}
}
