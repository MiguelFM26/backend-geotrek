<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_of_interest_id')->constrained('points_of_interest')->onDelete('cascade');
            $table->string('user_name');
            $table->integer('rating'); // De 1 a 5 estrellas
            $table->text('comment');
            $table->string('status')->default('Aprobado'); // 'Aprobado', 'Pendiente'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};