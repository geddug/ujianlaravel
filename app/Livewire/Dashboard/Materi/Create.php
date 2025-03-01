<?php

namespace App\Livewire\Dashboard\Materi;

use App\Models\Mapel;
use App\Models\Materi;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required', message: 'Masukkan materi')]
    public $nama_materi;
    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    public function store()
    {
        $this->validate();

        Materi::create([
            'nama_materi' => $this->nama_materi,
            'mapel_id' => $this->mapel_id
        ]);

        session()->flash('message', 'Data Berhasil Disimpan.');

        $this->redirectRoute('materi.create', navigate: true);
    }
    public function render()
    {
        $mapel = Mapel::orderBy('nama_mapel','asc')->get();
        return view('livewire.dashboard.materi.create',[
            'mapel' => $mapel
        ]);
    }
}
