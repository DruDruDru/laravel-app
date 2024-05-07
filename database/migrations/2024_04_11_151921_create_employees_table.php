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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string("firstname", 100);
            $table->string("lastname", 100);
            $table->string("patronymic", 100)->nullable();
            $table->date("birth_date");
            $table->string("gender");
            $table->foreign("gender")->references("gender")->on("genders")->nullOnDelete();
            $table->string("login", 255)->unique();
            $table->date("hire_date");
            $table->date("termination_date")->nullable();
            $table->decimal("salary", 10, 2)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
