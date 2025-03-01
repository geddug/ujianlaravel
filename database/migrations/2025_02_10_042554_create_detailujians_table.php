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
        Schema::create('detailujians', function (Blueprint $table) {
            $table->id();
            $table->integer('ujian_id');
            $table->integer('materi_id');
            $table->longText('arr_soal_id');
            $table->integer('urut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailujians');
    }
};
