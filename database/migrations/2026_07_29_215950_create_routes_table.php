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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Categorías para GeoTrek (Histórica, Leyendas, Gastronómica, etc.)
            $table->string('category')->default('Histórica'); 
            
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard'])->default('Easy');
            $table->decimal('distance_km', 8, 2)->default(0.00);
            $table->integer('estimated_duration_min')->default(0);
            $table->string('location_name')->nullable(); // Ej: "Puno Centro", "Chucuito"
            $table->string('image_url')->nullable(); // Foto de la ruta
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};