<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kyar_com_unit_fixes', function (Blueprint $table) {
            $table->id();

            $table->string('tractor_name')->unique();

            $table->integer('set_hitam')->default(0);
            $table->integer('set_merah')->default(0);
            $table->integer('hood_merah')->default(0);
            $table->integer('set_biru')->default(0);
            $table->integer('hood_biru')->default(0);
            $table->integer('set_grey')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyar_com_unit_fixes');
    }
};
