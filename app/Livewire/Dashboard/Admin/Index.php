<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $query = '';
    public $sortField ='id';
    public $sortAsc = false;
    public $search = '';
 
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
        return view('livewire.dashboard.admin.index', [
            'data' => User::where('role', '!=', 'siswa')
            ->where(function($query) {
                $query->where('name', 'like', '%'.$this->query.'%')
                      ->orWhere('email', 'like', '%'.$this->query.'%')
                      ->orWhere('phone', 'like', '%'.$this->query.'%');
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate(10)
        ]);
    }
    public function destroy($id)
    {
        User::destroy($id);
        session()->flash('message', 'Data Berhasil Dihapus.');
        $this->redirectRoute('admin.index');
    }
}
