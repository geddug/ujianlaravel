<?php

namespace App\Livewire\Dashboard\Mapel;

use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $query = '';
    public $sortField ='id';
    public $sortAsc = false;
    public $search = '';
 
    public function find() {
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
        return view('livewire.dashboard.mapel.index', [
            'data' => Mapel::where('nama_mapel', 'like', '%'.$this->query.'%')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate(10)
        ]);
    }
    public function destroy($id)
    {
        Mapel::destroy($id);
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('mapel.index', navigate: true);
    }
}
