<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);

        // Tạo thêm user test
        User::create([
            'name' => 'Nguyễn Văn Bằng',
            'email' => 'bang@example.com',
            'password' => Hash::make('123456'),
        ]);

        echo "✅ Created users:\n";
        echo "- admin@example.com / 123456\n";
        echo "- bang@example.com / 123456\n";
    }
}

