<?php

namespace App\Livewire\Dashboard\Ujian;

use App\Models\Mapel;
use App\Models\Ujian;
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
        $ujian = Ujian::with('mapel')
        ->when($this->query, function ($query) {
            $query->whereHas('mapel', function ($q) {
                $q->where('nama_ujian', 'like', '%'.$this->query.'%')
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
            $query->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                  ->orderBy('mapels.nama_mapel', $this->sortAsc ? 'asc' : 'desc');
        })
        ->when($this->sortField !== 'mapel.nama_mapel', function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })
        ->paginate(10);
        return view('livewire.dashboard.ujian.index',[
            'mapel' => $mapel,
            'data' => $ujian
        ]);
    }
    public function seton($id)
    {
        $data = Ujian::findOrFail($id);
        $data->update([
            'status' => "yes",
        ]);
        session()->flash('message', 'Status aktif.');
        //$this->redirectRoute('ujian.index', navigate: true);
    }
    public function setoff($id)
    {
        $data = Ujian::findOrFail($id);
        $data->update([
            'status' => "no",
        ]);
        session()->flash('message', 'Status non aktif.');
        //$this->redirectRoute('ujian.index', navigate: true);
    }
    public function destroy($id)
    {
        $data = Ujian::findOrFail($id);
        DB::table('detailujians')
            ->where('ujian_id', $id)
            ->delete();
        $data->delete();
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('ujian.index', navigate: true);
    }
}
