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
        Schema::create('movies_tables', function (Blueprint $table) {
            $table->char('id_movie', 5)->primary();
            $table->string('judul_movie', 30);
            $table->char('id_gendre', 4);
            $table->year('year');
            $table->string('poster',50);
            $table->timestamps();

            $table->foreign('id_gendre')->references('id_gendre')->on('genre_tables')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies_tables');
    }
};
