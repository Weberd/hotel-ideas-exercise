<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunting_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('experience_years')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('experience_years');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunting_guides');
    }
};
