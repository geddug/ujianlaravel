<?php

namespace App\Livewire\Dashboard\Tryout;

use App\Models\Mapel;
use App\Models\Tryout;
use Illuminate\Support\Facades\DB;
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
    public $selectedStatus = '';
 
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
        $tryout = Tryout::with('mapel')
        ->when($this->query, function ($query) {
            $query->whereHas('mapel', function ($q) {
                $q->where('nama_tryout', 'like', '%'.$this->query.'%')
                ->orWhere('nama_mapel', 'like', '%' . $this->query . '%');
            });
        })
        ->when($this->selectedMapel, function ($query) {
            $query->whereHas('mapel', function ($q) {
                $q->where('mapel_id', $this->selectedMapel);
            });
        })
        ->when($this->selectedStatus, function ($query) {
            $query->where('status', $this->selectedStatus);
        })
        ->when($this->sortField === 'mapel.nama_mapel', function ($query) {
            $query->join('mapels', 'mapels.id', '=', 'tryouts.mapel_id')
                  ->orderBy('mapels.nama_mapel', $this->sortAsc ? 'asc' : 'desc');
        })
        ->when($this->sortField !== 'mapel.nama_mapel', function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })
        ->paginate(10);
        return view('livewire.dashboard.tryout.index',[
            'mapel' => $mapel,
            'data' => $tryout
        ]);
    }
    public function seton($id)
    {
        $data = Tryout::findOrFail($id);
        $data->update([
            'status' => "yes",
        ]);
        session()->flash('message', 'Status aktif.');
        //$this->redirectRoute('ujian.index', navigate: true);
    }
    public function setoff($id)
    {
        $data = Tryout::findOrFail($id);
        $data->update([
            'status' => "no",
        ]);
        session()->flash('message', 'Status non aktif.');
        //$this->redirectRoute('ujian.index', navigate: true);
    }
    public function destroy($id)
    {
        $data = Tryout::findOrFail($id);
        $data->delete();
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('tryout.index', navigate: true);
    }
}
