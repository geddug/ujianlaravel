<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikutujian extends Model
{
    protected $fillable = [
        'ujian_id',
        'user_id',
        'arr_soal_id',
        'arr_jawaban',
        'start',
        'end',
        'status',
        'total_nilai',
    ];
    public function ujian() {
        return $this->belongsTo(Ujian::class,'ujian_id');
    }
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function detailikutujian() {
        return $this->hasMany(Detailikutujian::class,'ikutujian_id');
    }
}
