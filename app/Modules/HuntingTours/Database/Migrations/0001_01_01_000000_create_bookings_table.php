<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunting_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('tour_name');
            $table->string('hunter_name');
            $table->foreignId('guide_id')->constrained('hunting_guides')->onDelete('cascade');
            $table->date('date');
            $table->unsignedTinyInteger('participants_count');
            $table->timestamps();

            $table->index(['guide_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunting_bookings');
    }
};
