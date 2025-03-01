<?php

namespace App\Livewire\Dashboard\Soal;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    #[Rule('required', message: 'Masukkan materi')]
    public $materi_id;

    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    #[Rule('required', message: 'Masukkan pembobotan')]
    public $pembobotan;

    #[Rule('required', message: 'Masukkan pertanyaan')]
    public $pertanyaan;
    
    public $bobot;
    
    #[Rule('required', message: 'Masukkan opsi_a')]
    public $opsi_a;
    
    #[Rule('required', message: 'Masukkan opsi_b')]
    public $opsi_b;
    
    #[Rule('required', message: 'Masukkan opsi_c')]
    public $opsi_c;
    
    #[Rule('required', message: 'Masukkan opsi_d')]
    public $opsi_d;
    
    public $opsi_e;
    public $bobot_a;
    public $bobot_b;
    public $bobot_c;
    public $bobot_d;
    public $bobot_e;
    public $pembahasan;
    
    #[Rule('required', message: 'Masukkan jawaban')]
    public $jawaban;

    public function find() {
        $this->materi_id = null;
    }

    public function mount($id)
    {
        $data = Soal::find($id);

        $this->id   = $data->id;
        $this->materi_id = $data->materi_id;
        $this->mapel_id = $data->mapel_id;
        $this->pembobotan = $data->pembobotan;
        $this->pertanyaan = $data->pertanyaan;
        $this->bobot = $data->bobot;
        $this->opsi_a = $data->opsi_a;
        $this->opsi_b = $data->opsi_b;
        $this->opsi_c = $data->opsi_c;
        $this->opsi_d = $data->opsi_d;
        $this->opsi_e = $data->opsi_e;
        $this->bobot_a = $data->bobot_a;
        $this->bobot_b = $data->bobot_b;
        $this->bobot_c = $data->bobot_c;
        $this->bobot_d = $data->bobot_d;
        $this->bobot_e = $data->bobot_e;
        $this->pembahasan = $data->pembahasan;
        $this->jawaban = $data->jawaban;
    }

    public function store()
    {
        //dd($this->pertanyaan);
        $this->validate();

        if($this->opsi_e == null) {
            $this->opsi_e = "";
        }
        if($this->bobot_e == null) {
            $this->bobot_e = 0;
        }
        if($this->pembahasan == null) {
            $this->pembahasan = "";
        }

        $data = Soal::find($this->id);

        $data->update([
            'materi_id' => $this->materi_id,
            'mapel_id' => $this->mapel_id,
            'pembobotan' => $this->pembobotan,
            'pertanyaan' => $this->pertanyaan,
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
        ]);

        session()->flash('message', 'Data Berhasil Diupdate.');
        $this->redirectRoute('soal.edit',$this->id, navigate: true);
    }
    public function render()
    {
        $materi = array();
        if ($this->mapel_id != '') {
            $materi = Materi::where('mapel_id', $this->mapel_id)->orderBy('nama_materi', 'asc')->get();
        }
        $mapel = Mapel::orderBy('nama_mapel','asc')->get();
        return view('livewire.dashboard.soal.edit',[
            'mapel' => $mapel,
            'materi' => $materi
        ]);
    }
}
