<?php

namespace App\Livewire\Dashboard\Materi;

use App\Models\Mapel;
use App\Models\Materi;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $query = '';
    public $sortField ='id';
    public $sortAsc = false;
    public $search = '';
    public $selectedMapel = '';
 
    public function find()
    {
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if($this->sortField === $field)
        {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
    public function render()
    {
        $mapel = Mapel::orderBy('nama_mapel','asc')->get();
        $data = Materi::with('mapel')
            ->when($this->query, function ($query) {
                $query->whereHas('mapel', function ($q) {
                    $q->where('nama_materi', 'like', '%'.$this->query.'%')
                    ->orWhere('nama_mapel', 'like', '%' . $this->query . '%');
                });
            })
            ->when($this->selectedMapel, function ($query) {
                $query->whereHas('mapel', function ($q) {
                    $q->where('mapel_id', $this->selectedMapel);
                });
            })
            ->when($this->sortField === 'mapel.nama_mapel', function ($query) {
                $query->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                      ->orderBy('mapels.nama_mapel', $this->sortAsc ? 'asc' : 'desc');
            })
            ->when($this->sortField !== 'mapel.nama_mapel', function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);
        return view('livewire.dashboard.materi.index',[
            'data' => $data,
            'mapel' => $mapel
        ]);
    }
    public function destroy($id)
    {
        Materi::destroy($id);
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('materi.index', navigate: true);
    }
}
