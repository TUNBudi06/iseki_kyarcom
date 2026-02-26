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
        Schema::create('rack_part_lists', function (Blueprint $table) {
            $table->id();
            $table->string('rack_no')->nullable();
            $table->string('item_code');
            $table->string('part_name');
            $table->enum('cek',['BENAR','SALAH'])->nullable();
            $table->string('supplier')->nullable();
            $table->boolean('part_hydrolis')->default(false);
            $table->string('type_tractor')->nullable();
            $table->string('satuan')->nullable();
            $table->string('sample')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rack_part_lists');
    }
};
