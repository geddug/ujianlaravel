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
        Schema::create('detailikutujians', function (Blueprint $table) {
            $table->id();
            $table->integer('ikutujian_id');
            $table->integer('materi_id');
            $table->integer('benar');
            $table->integer('salah');
            $table->integer('kosong');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailikutujians');
    }
};
