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
        Schema::create('employee_position', function (Blueprint $table) {
            $table->id();
            $table->integer("position_id");
            $table->integer("employee_id");
            $table->foreign("position_id")->references("id")->on("positions")->cascadeOnDelete();
            $table->foreign("employee_id")->references("id")->on("employees")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_position');
    }
};