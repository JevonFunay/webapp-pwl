<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('nim', 8)->nullable()->unique()->after('id');
            $table->string('role', 20)->default('mahasiswa')->after('password');
            $table->foreign('nim')->references('nim')->on('mahasiswas')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['nim']);
            $table->dropUnique(['nim']);
            $table->dropColumn(['nim', 'role']);
        });
    }
};
