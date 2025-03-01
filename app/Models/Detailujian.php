<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailujian extends Model
{
    use HasFactory;
    protected $fillable = [
        'ujian_id',
        'arr_soal_id',
        'urut',
        'materi_id'
    ];
    public function ujian() {
        return $this->belongsTo(Ujian::class,'ujian_id');
    }
}
