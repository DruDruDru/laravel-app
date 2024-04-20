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
        Schema::create('position_subdivision', function (Blueprint $table) {
            $table->id();
            $table->integer("subdivision_code");
            $table->integer("position_id");
            $table->foreign("position_id")->references("id")->on("positions")->cascadeOnDelete();
            $table->foreign("subdivision_code")->references("subdivision_code")->on("subdivisions")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_subdivision');
    }
};