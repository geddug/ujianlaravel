<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $fillable = [
        'nama_ujian',
        'mapel_id',
        'materi_id',
        'user_id',
        'soal_id',
        'jumlah_soal',
        'waktu',
        'status',
        're_ujian',
        'hitung_minus',
        'acak',
        'tampil_pembahasan',
        'nilai_minimum',
        'nilai_maksimum',
        'set_on',
        'set_off',
    ];
    public function mapel() {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
    public function detailujian() {
        return $this->hasMany(Detailujian::class,'ujian_id');
    }
}
