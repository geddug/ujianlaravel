<?php

namespace App\Livewire\Dashboard\Ujian;

use App\Models\Detailujian;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public $selectMapel;
    public $selectMateri;
    public $soal = [];
    public $sementara = [];

    #[Rule('required', message: 'Masukkan nama ujian')]
    public $nama_ujian;

    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    #[Rule('required', message: 'Masukkan waktu')]
    public $waktu;

    #[Rule('required', message: 'Masukkan status')]
    public $status;

    #[Rule('required', message: 'Masukkan re ujian')]
    public $re_ujian = 1;

    #[Rule('required', message: 'Masukkan hitung minus')]
    public $hitung_minus;

    #[Rule('required', message: 'Masukkan acak')]
    public $acak;

    #[Rule('required', message: 'Masukkan tampil pembahasan')]
    public $tampil_pembahasan;

    public $nilai_minimum = 0;
    public $nilai_maksimum = 0;

    protected $listeners = ['updateSementara'];
    public function updateSementara($values)
    {
        $this->sementara = $values['values'];
    }
    public function addSoal($id)
    {
        $this->soal[] = $id;
        $this->sementara = [];
    }
    public function findMateri()
    {
        $this->selectMateri = null;
        $this->sementara = [];
    }
    public function findSoal()
    {
        //$this->selectMateri = null;
    }
    public function tempSoal()
    {
        $temp = $this->soal;
        $add = $this->sementara;
        $materi = $this->selectMateri;
        $temp[$materi] = $add;
        $this->soal = $temp;
    }
    public function editSoal($id)
    {
        $temp = $this->soal;
        $materi = Materi::where('nama_materi', $id)->first();
        $this->selectMapel = $materi->mapel_id;
        $this->selectMateri = $materi->id;
        $this->sementara = $temp[$materi->id];
    }
    public function hapusSoal($id)
    {
        $temp = $this->soal;
        $materi = Materi::where('nama_materi', $id)->first();
        unset($temp[$materi->id]);
        $this->soal = $temp;
    }
    public function store()
    {
        $this->validate();
        if ($this->soal == NULL) {
            session()->flash('message', 'Soal tidak dipilih.');
            $this->redirectRoute('ujian.create', navigate: true);
        } else {
            $jml_soal = array();
            foreach ($this->soal as $k => $v) {
                $jml_soal[] = count($v);
            }
            $ujian = Ujian::create([
                'mapel_id' => $this->mapel_id,
                'nama_ujian' => $this->nama_ujian,
                'waktu' => $this->waktu,
                'status' => $this->status,
                're_ujian' => $this->re_ujian,
                'hitung_minus' => $this->hitung_minus,
                'acak' => $this->acak,
                'tampil_pembahasan' => $this->tampil_pembahasan,
                'nilai_minimum' => $this->nilai_minimum,
                'nilai_maksimum' => $this->nilai_maksimum,
                'user_id' => Auth::user()->id,
                'jumlah_soal' => array_sum($jml_soal)
            ]);

            $x = 1;
            foreach ($this->soal as $k => $v) {
                Detailujian::create([
                    'materi_id' => $k,
                    'ujian_id' => $ujian->id,
                    'arr_soal_id' => implode(',', $v),
                    'urut' => $x
                ]);
                $x++;
            }

            session()->flash('message', 'Data Berhasil Disimpan.');

            $this->redirectRoute('ujian.create', navigate: true);
        }
    }
    public function render()
    {
        $mapel = Mapel::orderBy('nama_mapel', 'asc')->get();
        $materi = array();
        if ($this->selectMapel != '') {
            $materi = Materi::orderBy('nama_materi', 'asc')
                ->when($this->selectMapel, function ($query) {
                    $query->where('mapel_id', $this->selectMapel);
                })
                ->whereIn('id', Soal::pluck('materi_id'))
                ->get();
        }
        $isi_soal = array();
        $soal_edit = array();
        if ($this->selectMateri != '') {
            $cek_soal = Soal::where('materi_id', $this->selectMateri)->orderBy('id', 'desc')->get();
            foreach ($cek_soal as $k) {
                $cek_ujian = Detailujian::with('ujian')->whereRaw("FIND_IN_SET(?, arr_soal_id)", [$k->id])->get();
                $tempu = array();
                foreach ($cek_ujian as $c) {
                    $tempu[] = $c->ujian->nama_ujian;
                }
                $k['use'] = $tempu;
                $isi_soal[] = $k;
                $soal_edit[] = $k;
            }
        }

        $tempsoal = $this->soal;
        $tempmateri = Materi::orderBy('nama_materi', 'asc')->get();
        $soal_sementara = array();
        
        foreach ($tempsoal as $k => $v) {
            foreach ($tempmateri as $m) {
                if ($k == $m->id) {
                    $soal_sementara[$m->nama_materi] = $v;
                    
                }
            }
        }
        return view('livewire.dashboard.ujian.create', [
            'mapel' => $mapel,
            'materi' => $materi,
            'isi_soal' => $isi_soal,
            'soal_sementara' => $soal_sementara,
            'soal_edit' => $soal_edit
        ]);
    }
}
