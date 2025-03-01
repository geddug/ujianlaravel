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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('mapel_id');
            $table->integer('materi_id');
            $table->string('pembobotan');
            $table->longText('pertanyaan');
            $table->integer('bobot');
            $table->longText('opsi_a');
            $table->integer('bobot_a');
            $table->longText('opsi_b');
            $table->integer('bobot_b');
            $table->longText('opsi_c');
            $table->integer('bobot_c');
            $table->longText('opsi_d');
            $table->integer('bobot_d');
            $table->longText('opsi_e');
            $table->integer('bobot_e');
            $table->longText('pembahasan');
            $table->longText('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
