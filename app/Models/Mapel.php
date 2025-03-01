<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Mapel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_mapel',
    ];
    public function materi() {
        return $this->hasMany(Materi::class,'mapel_id');
    }
    public function soal() {
        return $this->hasMany(Soal::class,'mapel_id');
    }
    public function ujian() {
        return $this->hasMany(Soal::class,'mapel_id');
    }
}
