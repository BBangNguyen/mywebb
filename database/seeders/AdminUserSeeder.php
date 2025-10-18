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
        // Cập nhật role cho tài khoản admin duy nhất
        $adminUser = User::where('email', 'bangcn12@gmail.com')->first();
        if ($adminUser) {
            $adminUser->update(['role' => 'admin']);
            echo "✅ Updated bangcn12@gmail.com to Admin role\n";
        } else {
            echo "⚠️ bangcn12@gmail.com not found\n";
        }

        // Đảm bảo tất cả tài khoản khác là user
        User::where('email', '!=', 'bangcn12@gmail.com')->update(['role' => 'user']);
        
        echo "✅ Role configuration:\n";
        echo "- bangcn12@gmail.com / 123456 → Admin Panel\n";
        echo "- All other accounts → Shop Page\n";
    }
}

