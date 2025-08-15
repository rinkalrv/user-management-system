<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('user_mobile_no')->nullable();
            $table->enum('user_type', ['admin', 'user', 'employee'])->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_status', ['active', 'inactive'])->default('inactive');
            $table->string('activation_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};