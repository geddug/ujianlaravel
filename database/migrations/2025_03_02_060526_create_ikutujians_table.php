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
        Schema::create('ikutujians', function (Blueprint $table) {
            $table->id();
            $table->integer('ujian_id');
            $table->string('user_id');
            $table->longText('arr_soal_id');
            $table->longText('arr_jawaban');
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
            $table->string('status');
            $table->integer('total_nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikutujians');
    }
};
