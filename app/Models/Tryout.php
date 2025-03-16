<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    protected $fillable = [
        'user_id',
        'nama_tryout',
        'mapel_id',
        'arr_ujian_id',
        're_tryout',
        'jeda_waktu',
        'merge_ujian',
        'status'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
