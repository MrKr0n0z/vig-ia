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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('camera_id');
            $table->string('location');
            $table->integer('track_id');
            $table->enum('alert_type', ['persona_detenida', 'movimiento_sospechoso']);
            $table->text('description');
            $table->integer('duration_seconds');
            $table->integer('frame_count');
            $table->timestamp('alert_timestamp');
            $table->boolean('is_viewed')->default(false);
            $table->boolean('is_false_alarm')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Índices para mejorar performance
            $table->index(['camera_id', 'alert_timestamp']);
            $table->index(['alert_type', 'is_viewed']);
            $table->index('alert_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
