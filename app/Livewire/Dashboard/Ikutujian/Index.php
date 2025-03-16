<?php

namespace App\Livewire\Dashboard\Ikutujian;

use App\Models\Detailikutujian;
use App\Models\Ikutujian;
use App\Models\Soal;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $id;
    
    public function selesai($id)
    {
        $data = Ikutujian::find($id);
        $arr_jawaban = explode(',', $data->arr_jawaban);
        $arr_soal = explode(',', $data->arr_soal_id);
        $ujian = Ujian::find($data->ujian_id);
        $soal = Soal::with('materi')->whereIn('id', $arr_soal)->orderByRaw("FIELD(id, " . implode(',', $arr_soal) . ")")->get();
        $jawaban = array();
        foreach ($arr_jawaban as $k => $v) {
            $expv = explode(':', $v);
            if (isset($expv[1])) {
                $jawaban[$expv[0]] = $expv[1];
            } else {
                $jawaban[$expv[0]] = "";
            }
        }
        $arr_materi = array();
        foreach ($soal as $k) {
            $bobot = 0;
            $opsi = 'bobot_' . $jawaban[$k->id];
            if ($jawaban[$k->id] == $k->jawaban) {
                if ($k->bobot > 0) {
                    $bobot = $k->bobot;
                } else {
                    $bobot = $k->$opsi;
                }
                $arr_materi[$k->materi_id]['benar'][] = 1;
                $arr_materi[$k->materi_id]['bobot'][] = $bobot;
            } elseif ($jawaban[$k->id] != $k->jawaban) {
                if ($ujian->hitung_minus == "yes") {
                    $bobot = -1;
                } else {
                    $bobot = $k->$opsi;
                }
                $arr_materi[$k->materi_id]['salah'][] = 1;
                $arr_materi[$k->materi_id]['bobot'][] = $bobot;
            } else {
                if ($ujian->hitung_minus == "yes") {
                    $bobot = -1;
                }
                $arr_materi[$k->materi_id]['kosong'][] = 1;
                $arr_materi[$k->materi_id]['bobot'][] = $bobot;
            }
        }
        DB::table('detailikutujians')->where('ikutujian_id', $data->id)->delete();
        $arr_bobot = array();
        foreach ($arr_materi as $k => $v) {
            $materi = $k;
            $bobot = 0;
            $benar = 0;
            $salah = 0;
            $kosong = 0;

            if (isset($v['bobot'])) {
                $bobot = array_sum($v['bobot']);
            }
            if (isset($v['benar'])) {
                $benar = array_sum($v['benar']);
            }
            if (isset($v['salah'])) {
                $salah = array_sum($v['salah']);
            }
            if (isset($v['kosong'])) {
                $kosong = array_sum($v['kosong']);
            }
            $arr_bobot[] = $bobot;
            
            Detailikutujian::create([
                'ikutujian_id' => $data->id,
                'materi_id' => $materi,
                'benar' => $benar,
                'salah' => $salah,
                'kosong' => $kosong,
                'nilai' => $bobot
            ]);
        }
        $data->update([
            'status' => "sudah",
            'total_nilai' => array_sum($arr_bobot)
        ]);
        $this->redirectRoute('pembahasanujian.index', $data->id, navigate: true);
    }
    public function jawab($id, $soal, $jawaban)
    {
        $data = Ikutujian::find($id);
        $arr_jawaban = explode(',', $data->arr_jawaban);
        $newarr = array();
        foreach ($arr_jawaban as $k => $v) {
            $expv = explode(':', $v);
            if ($soal == $expv[0]) {
                if (isset($expv[1]) && $expv[1] == $jawaban) {
                    $expv[1] = "";
                } else {
                    $expv[1] = $jawaban;
                }
            }
            $newarr[] = implode(':', $expv);
        }
        $data->update([
            'arr_jawaban' => implode(',', $newarr),
        ]);
    }
    public function render()
    {
        $ujian = Ujian::with('detailujian')->findOrFail($this->id);

        $ikutujian = Ikutujian::where('status', 'belum')->where('ujian_id',$this->id)->first();
        if ($ikutujian) {
            $arr_soal = explode(',', $ikutujian->arr_soal_id);
            $expired = Carbon::createFromFormat('Y-m-d H:i:s', $ikutujian->end, 'Asia/Bangkok');
        } else {
            $expired = Carbon::now('Asia/Bangkok')->addMinutes($ujian->waktu);
            $arr_soal = array();
            foreach ($ujian->detailujian as $k) {
                $tempsoal = explode(',', $k->arr_soal_id);
                if ($ujian->acak == 'yes') {
                    shuffle($tempsoal);
                }
                $arr_soal = array_merge($arr_soal, $tempsoal);
            }
            $ikutujian = Ikutujian::create([
                'ujian_id' => $this->id,
                'user_id' => Auth::user()->id,
                'arr_soal_id' => implode(',', $arr_soal),
                'arr_jawaban' => implode(',', $arr_soal),
                'status' => 'belum',
                'total_nilai' => "0",
                'start' => Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s'),
                'end' => $expired->format('Y-m-d H:i:s')
            ]);
        }
        $ikutujianid = $ikutujian->id;
        $arr_jawaban = explode(',', $ikutujian->arr_jawaban);
        $jawaban = array();
        foreach ($arr_jawaban as $k => $v) {
            $expv = explode(':', $v);
            if (isset($expv[1])) {
                $jawaban[$expv[0]] = $expv[1];
            } else {
                $jawaban[$expv[0]] = "";
            }
        }
        // dd([
        //     'original' => $expired, // The raw timestamp from the database
        //     'converted_utc' => $expired->copy()->timezone('UTC')->toIso8601String(),
        //     'converted_gmt7' => $expired->copy()->timezone('Asia/Bangkok')->toIso8601String(),
        // ]);

        $soal = Soal::with('materi')->whereIn('id', $arr_soal)->orderByRaw("FIELD(id, " . implode(',', $arr_soal) . ")")->get();
        return view('livewire.dashboard.ikutujian.index', [
            'ujian' => $ujian,
            'soal' => $soal,
            'jawaban' => $jawaban,
            'ikutujianid' => $ikutujianid,
            'expired' => $expired->timezone('UTC')->toIso8601String()
        ]);
    }
}
