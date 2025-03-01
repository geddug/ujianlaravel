<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    public $id;
    #[Rule('required', message: 'Masukkan nama')]
    public $name;

    #[Rule('required', message: 'Masukkan email')]
    public $email;

    #[Rule('required', message: 'Masukkan telp')]
    public $phone;

    public function mount()
    {
        $data = User::find(Auth::user()->id);

        $this->id   = $data->id;
        $this->name = $data->name;
        $this->phone = $data->phone;
        $this->email = $data->email;
    }
    public function store()
    {
        $this->validate();
        $data = User::find($this->id);

        $data->update([
            'phone' => $this->phone,
            'email' => $this->email,
            'name' => $this->name,
        ]);

        session()->flash('message', 'Data Berhasil Diupdate.');
        $this->redirectRoute('profile.index', navigate: true);
    }
    public function render()
    {
        return view('livewire.dashboard.profile.index');
    }
}
