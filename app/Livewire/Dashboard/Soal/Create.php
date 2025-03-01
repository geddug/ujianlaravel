<?php

namespace App\Livewire\Dashboard\Soal;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required', message: 'Masukkan materi')]
    public $materi_id;

    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    #[Rule('required', message: 'Masukkan pembobotan')]
    public $pembobotan;

    #[Rule('required', message: 'Masukkan pertanyaan')]
    public $pertanyaan;

    public $bobot = 0;

    #[Rule('required', message: 'Masukkan opsi_a')]
    public $opsi_a;

    #[Rule('required', message: 'Masukkan opsi_b')]
    public $opsi_b;

    #[Rule('required', message: 'Masukkan opsi_c')]
    public $opsi_c;

    #[Rule('required', message: 'Masukkan opsi_d')]
    public $opsi_d;

    public $opsi_e = "";
    public $bobot_a = 0;
    public $bobot_b = 0;
    public $bobot_c = 0;
    public $bobot_d = 0;
    public $bobot_e = 0;
    public $pembahasan = "";

    #[Rule('required', message: 'Masukkan jawaban')]
    public $jawaban;

    public function find() {
        $this->materi_id = null;
    }

    public function store()
    {
        //dd($this->pertanyaan);
        $this->validate();
        
        Soal::create([
            'materi_id' => $this->materi_id,
            'mapel_id' => $this->mapel_id,
            'pembobotan' => $this->pembobotan,
            'pertanyaan' => $this->pertanyaan,
            'pembobotan' => $this->pembobotan,
            'bobot' => $this->bobot,
            'opsi_a' => $this->opsi_a,
            'opsi_b' => $this->opsi_b,
            'opsi_c' => $this->opsi_c,
            'opsi_d' => $this->opsi_d,
            'opsi_e' => $this->opsi_e,
            'bobot_a' => $this->bobot_a,
            'bobot_b' => $this->bobot_b,
            'bobot_c' => $this->bobot_c,
            'bobot_d' => $this->bobot_d,
            'bobot_e' => $this->bobot_e,
            'pembahasan' => $this->pembahasan,
            'jawaban' => $this->jawaban,
            'user_id' => Auth::user()->id
        ]);

        session()->flash('message', 'Data Berhasil Disimpan.');

        $this->redirectRoute('soal.create', navigate: true);
    }
    public function render()
    {
        $materi = array();
        if ($this->mapel_id != '') {
            $materi = Materi::where('mapel_id', $this->mapel_id)->orderBy('nama_materi', 'asc')->get();
        }
        $mapel = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('livewire.dashboard.soal.create', [
            'mapel' => $mapel,
            'materi' => $materi
        ]);
    }
}
