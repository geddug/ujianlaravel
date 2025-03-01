<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'mapel_id',
        'materi_id',
        'pembobotan',
        'pertanyaan',
        'bobot',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'bobot_a',
        'bobot_b',
        'bobot_c',
        'bobot_d',
        'bobot_e',
        'pembahasan',
        'jawaban',
    ];
    public function mapel() {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
    public function materi() {
        return $this->belongsTo(Materi::class,'materi_id');
    }
}
