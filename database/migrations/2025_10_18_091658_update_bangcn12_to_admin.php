<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set bangcn12@gmail.com as admin
        User::where('email', 'bangcn12@gmail.com')->update(['role' => 'admin']);
        
        // Set all other users as regular users
        User::where('email', '!=', 'bangcn12@gmail.com')->update(['role' => 'user']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: set bangcn12 back to user
        User::where('email', 'bangcn12@gmail.com')->update(['role' => 'user']);
    }
};
