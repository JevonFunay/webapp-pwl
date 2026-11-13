<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->date('tanggal')->nullable();
            $table->char('nim', 8)->nullable();

            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->dropForeign(['nim']);
            $table->dropColumn(['tanggal', 'nim']);
        });
    }
};
