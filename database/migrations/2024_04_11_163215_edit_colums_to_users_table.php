<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn("name", "login");
            $table->dropColumn(["email", "email_verified_at", "created_at", "updated_at", "remember_token"]);
            $table->addColumn("string", "role");
            $table->foreign("role")->references("role")->on("roles")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn("login", "name");
            $table->addColumn("string", "email");
            $table->addColumn("timestamp", "email_verified_at");
            $table->addColumn("timestamp", "created_at");
            $table->addColumn("timestamp", "updated_at");
            $table->addColumn("string", "remember_token");
            $table->dropColumn("role");
        });
    }
};
