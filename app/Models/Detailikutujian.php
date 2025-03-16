<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detailikutujian extends Model
{
    protected $fillable = [
        'ikutujian_id',
        'materi_id',
        'benar',
        'salah',
        'kosong',
        'nilai',
    ];
    public function ikutujian() {
        return $this->belongsTo(Ikutujian::class,'ikutujian_id');
    }
    public function materi() {
        return $this->belongsTo(Materi::class,'materi_id');
    }
}
