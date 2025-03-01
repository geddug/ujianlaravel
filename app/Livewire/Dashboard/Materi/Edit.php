<?php

namespace App\Livewire\Dashboard\Materi;

use App\Models\Mapel;
use App\Models\Materi;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    #[Rule('required', message: 'Masukkan materi')]
    public $nama_materi;
    #[Rule('required', message: 'Masukkan mapel')]
    public $mapel_id;

    public function mount($id)
    {
        $data = Materi::find($id);

        $this->id   = $data->id;
        $this->nama_materi = $data->nama_materi;
        $this->mapel_id = $data->mapel_id;
    }

    public function store()
    {
        $this->validate();

        $data = Materi::find($this->id);

        $data->update([
            'nama_materi' => $this->nama_materi,
            'mapel_id' => $this->mapel_id
        ]);

        session()->flash('message', 'Data Berhasil Diupdate.');
        $this->redirectRoute('materi.edit',$this->id, navigate: true);
    }
    public function render()
    {
        $mapel = Mapel::orderBy('nama_mapel','asc')->get();
        return view('livewire.dashboard.materi.edit',[
            'mapel' => $mapel
        ]);
    }
}
