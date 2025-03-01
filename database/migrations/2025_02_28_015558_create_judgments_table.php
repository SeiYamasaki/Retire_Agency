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
        Schema::create('judgments', function (Blueprint $table) {
            $table->id();
            $table->string('conflict');
            $table->string('public_servant');
            $table->string('licensed_professional');
            $table->string('contractor');
            $table->string('foreign_trainee');
            $table->string('mental_illness');
            $table->string('trouble');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judgments');
    }
};
