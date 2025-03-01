<?php

namespace App\Livewire\Dashboard\Mapel;

use App\Models\Mapel;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $id;

    #[Rule('required', message: 'Masukkan mapel')]
    public $nama_mapel;

    public function mount($id)
    {
        $data = Mapel::find($id);

        $this->id   = $data->id;
        $this->nama_mapel = $data->nama_mapel;
    }

    public function store()
    {
        $this->validate();

        $data = Mapel::find($this->id);

        $data->update([
            'nama_mapel' => $this->nama_mapel,
        ]);

        session()->flash('message', 'Data Berhasil Diupdate.');
        $this->redirectRoute('mapel.edit',$this->id, navigate: true);
    }

    public function render()
    {
        return view('livewire.dashboard.mapel.edit');
    }
}
