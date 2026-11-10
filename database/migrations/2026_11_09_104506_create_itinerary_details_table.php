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
    Schema::create('itinerary_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
        $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
        $table->unsignedInteger('sort_order');
        $table->date('visit_date')->nullable();
        $table->time('visit_time')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_details');
    }
};
