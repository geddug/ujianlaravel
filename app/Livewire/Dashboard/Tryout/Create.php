<?php

namespace App\Livewire\Dashboard\Tryout;

use App\Models\Detailtryout;
use App\Models\Mapel;
use App\Models\Tryout;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public $selectMapel;
    public $ujian = [];
    public $sementara = [];

    #[Rule('required', message: 'Masukkan nama tryout')]
    public $nama_tryout;

    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    #[Rule('required', message: 'Pilih status')]
    public $status;

    #[Rule('required', message: 'Masukkan jeda')]
    public $jeda_waktu = 0;

    #[Rule('required', message: 'Pilih merge')]
    public $merge_ujian;

    #[Rule('required', message: 'Masukkan re tryout')]
    public $re_tryout = 2;

    public function findujian()
    {
        $this->sementara = [];
    }
    public function tempujian()
    {
        $temp = $this->ujian;
        $add = $this->sementara;
        $mapel = $this->selectMapel;
        $temp[$mapel] = $add;
        $this->ujian = $temp;
    }
    public function editujian($id)
    {
        $temp = $this->ujian;
        $mapel = Mapel::where('nama_mapel', $id)->first();
        $this->selectMapel = $mapel->id;
        $this->sementara = $temp[$mapel->id];
    }
    public function hapusujian($id)
    {
        $temp = $this->ujian;
        $mapel = Mapel::where('nama_mapel', $id)->first();
        unset($temp[$mapel->id]);
        $this->ujian = $temp;
    }
    public function store()
    {
        $this->validate();
        if ($this->ujian == NULL) {
            session()->flash('message', 'ujian tidak dipilih.');
            $this->redirectRoute('tryout.create', navigate: true);
        } else {
            $arr_ujian = array();
            foreach ($this->ujian as $k => $v) {
                $arr_ujian[] = implode(',', $v);
            }
            $tryout = Tryout::create([
                'mapel_id' => $this->mapel_id,
                'nama_tryout' => $this->nama_tryout,
                'jeda_waktu' => $this->jeda_waktu,
                'status' => $this->status,
                're_tryout' => $this->re_tryout,
                'merge_ujian' => $this->merge_ujian,
                'user_id' => Auth::user()->id,
                'arr_ujian_id' => implode(',',$arr_ujian),
            ]);

            session()->flash('message', 'Data Berhasil Disimpan.');

            $this->redirectRoute('tryout.create', navigate: true);
        }
    }

    public function render()
    {
        $mapel = Mapel::orderBy('nama_mapel', 'asc')->get();
        $isi_ujian = array();
        $ujian_edit = array();
        if ($this->selectMapel != '') {
            $isi_ujian = Ujian::orderBy('nama_ujian', 'asc')
                ->when($this->selectMapel, function ($query) {
                    $query->where('mapel_id', $this->selectMapel);
                })
                ->get();
            $ujian_edit = $isi_ujian;
        }
        $ujian_sementara = array();
        $tempujian = $this->ujian;
        $tempmapel = Mapel::orderBy('nama_mapel', 'asc')->get();
        
        foreach ($tempujian as $k => $v) {
            foreach ($tempmapel as $m) {
                if ($k == $m->id) {
                    $ujian_sementara[$m->nama_mapel] = $v;
                }
            }
        }

        return view('livewire.dashboard.tryout.create', [
            'mapel' => $mapel,
            'isi_ujian' => $isi_ujian,
            'ujian_sementara' => $ujian_sementara,
            'ujian_edit' => $ujian_edit,
        ]);
    }
}
