<?php

namespace App\Livewire\Dashboard\Soal;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Soal;
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
    public $selectedMateri = '';
 
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
        $materi = Materi::orderBy('nama_materi','asc')
        ->when($this->selectedMapel, function ($query) {
            $query->where('mapel_id', $this->selectedMapel);
        })
        ->get();
        $data = Soal::with('mapel')->with('materi')
        ->when($this->query, function ($query) {
            $query->whereHas('mapel', function ($q) {
                $q->where('nama_materi', 'like', '%'.$this->query.'%')
                ->orWhere('nama_mapel', 'like', '%' . $this->query . '%')
                ->orWhere('pertanyaan', 'like', '%' . $this->query . '%');
            });
        })
        ->when($this->selectedMapel, function ($query) {
            $query->whereHas('mapel', function ($q) {
                $q->where('mapel_id', $this->selectedMapel);
            });
        })
        ->when($this->selectedMateri, function ($query) {
            $query->whereHas('materi', function ($q) {
                $q->where('materi_id', $this->selectedMateri);
            });
        })
        ->when($this->sortField === 'mapel.nama_mapel' && $this->sortField != 'materi.nama_materi', function ($query) {
            $query->join('mapels', 'mapels.id', '=', 'soals.mapel_id')
                  ->orderBy('mapels.nama_mapel', $this->sortAsc ? 'asc' : 'desc');
        })
        ->when($this->sortField === 'materi.nama_materi' && $this->sortField != 'mapel.nama_mapel', function ($query) {
            $query->join('materis', 'materis.id', '=', 'soals.materi_id')
                  ->orderBy('materis.nama_materi', $this->sortAsc ? 'asc' : 'desc');
        })
        ->when($this->sortField !== 'mapel.nama_mapel' && $this->sortField != 'materi.nama_materi', function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })
        ->paginate(10);
        return view('livewire.dashboard.soal.index',[
            'data' => $data,
            'mapel' => $mapel,
            'materi' => $materi
        ]);
    }
    public function destroy($id)
    {
        Soal::destroy($id);
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('soal.index', navigate: true);
    }
}
