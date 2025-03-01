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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ujian');
            $table->integer('mapel_id');
            $table->integer('user_id');
            $table->integer('jumlah_soal');
            $table->integer('waktu');
            $table->string('status');
            $table->integer('re_ujian');
            $table->string('hitung_minus');
            $table->string('acak');
            $table->string('tampil_pembahasan');
            $table->integer('nilai_minimum');
            $table->integer('nilai_maksimum');
            $table->datetime('set_on')->nullable();
            $table->datetime('set_off')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
