<?php

namespace App\Livewire\Dashboard\Mapel;

use App\Models\Mapel;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required', message: 'Masukkan mapel')]
    public $nama_mapel;

    public function store()
    {
        $this->validate();

        Mapel::create([
            'nama_mapel' => $this->nama_mapel,
        ]);

        session()->flash('message', 'Data Berhasil Disimpan.');

        $this->redirectRoute('mapel.create', navigate: true);
    }
    public function render()
    {
        return view('livewire.dashboard.mapel.create');
    }
}
