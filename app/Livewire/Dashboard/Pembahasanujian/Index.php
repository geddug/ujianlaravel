<?php

namespace App\Livewire\Dashboard\Pembahasanujian;

use App\Models\Ikutujian;
use App\Models\Soal;
use App\Models\Ujian;
use Livewire\Component;

class Index extends Component
{
    public $id;

    public function render()
    {
        $data = Ikutujian::with('detailikutujian')->where('id', $this->id)->where('status', 'sudah')->first();
        $arr_hasil = array('benar' => 0, 'salah' => 0, 'kosong' => 0, 'bobot' => 0);
        foreach ($data->detailikutujian as $k) {
            $arr_hasil['benar'] += $k->benar;
            $arr_hasil['salah'] += $k->salah;
            $arr_hasil['kosong'] += $k->kosong;
            $arr_hasil['bobot'] += $k->nilai;
        }
        $arr_jawaban = explode(',', $data->arr_jawaban);
        $arr_soal = explode(',',$data->arr_soal_id);
        $ujian = Ujian::with('detailujian')->findOrFail($data->ujian_id);
        $jawaban = array();
        foreach ($arr_jawaban as $k => $v) {
            $expv = explode(':', $v);
            if (isset($expv[1])) {
                $jawaban[$expv[0]] = $expv[1];
            } else {
                $jawaban[$expv[0]] = "";
            }
        }
        $soal = Soal::with('materi')->whereIn('id', $arr_soal)->orderByRaw("FIELD(id, " . implode(',', $arr_soal) . ")")->get();
        return view('livewire.dashboard.pembahasanujian.index', [
            'ujian' => $ujian,
            'soal' => $soal,
            'jawaban' => $jawaban,
            'data' => $data,
            'hasil' => $arr_hasil
        ]);
    }
}
