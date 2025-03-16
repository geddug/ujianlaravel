<?php

namespace App\Livewire\Dashboard\Hasilujian;

use App\Models\Ikutujian;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
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
        $data = Ikutujian::with('ujian')
        ->when($this->query, function ($query) {
            $query->whereHas('ujian', function ($q) {
                $q->where('nama_ujian', 'like', '%'.$this->query.'%');
            });
        })
        ->where('user_id',Auth::user()->id)
        ->when($this->selectedMapel, function ($query) {
            $query->whereHas('ujian', function ($q) {
                $q->where('mapel_id', $this->selectedMapel);
            });
        })
        ->when($this->sortField === 'ujian.nama_ujian', function ($query) {
            $query->join('ujians', 'ujians.id', '=', 'ikutujians.ujian_id')
                  ->orderBy('ujian.nama_ujian', $this->sortAsc ? 'asc' : 'desc');
        })
        ->when($this->sortField !== 'ujian.nama_ujian', function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })
        ->paginate(10);
        return view('livewire.dashboard.hasilujian.index', [
            'data' => $data,
            'mapel' => $mapel
        ]);
    }
}
