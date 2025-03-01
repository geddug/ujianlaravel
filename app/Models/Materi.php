<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Materi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_materi',
        'mapel_id'
    ];
    public function mapel() {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
    public function soal() {
        return $this->hasMany(Soal::class,'materi_id');
    }
}
