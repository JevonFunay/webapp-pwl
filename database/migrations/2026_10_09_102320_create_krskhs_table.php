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
        Schema::create('krskhs', function (Blueprint $table) {
            $table->id('idKrs');
            $table->unsignedBigInteger('noReg')->nullable();
            $table->unsignedBigInteger('jadwalId')->nullable();
            $table->char('nilai', 2)->default('E');
            $table->timestamps();

            //foreign key ke tabel registrasis
            $table->foreign('noReg')
            ->references('noReg')
            ->on('registrasis')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            //foreign key ke tabel jadwals
            $table->foreign('jadwalId')
            ->references('jadwalId')
            ->on('jadwals')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krskhs');
    }
};
