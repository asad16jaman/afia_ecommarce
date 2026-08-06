<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('type', ['admin','user','staff']);
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->enum('status', ['a', 'p', 'd'])->default('a')->comment('a=active, p=pending, d=deactive');
            $table->rememberToken();
            $table->ipAddress('ip_address');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });


        // create default one
        $user = new User();
        $user->name = 'Mr. Admin';
        $user->email = 'admin@mail.com';
        $user->type = 'admin';
        $user->username = 'admin';
        $user->phone = '00000000000';
        $user->password = bcrypt(123456789);
        $user->ip_address = request()->ip();
        $user->status = 'a';
        $user->save();

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
