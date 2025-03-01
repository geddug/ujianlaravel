<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    public $password;
    #[Rule('required', message: 'Masukkan nama')]
    public $name;

    #[Rule('required', message: 'Masukkan email')]
    public $email;

    #[Rule('required', message: 'Masukkan telp')]
    public $phone;

    #[Rule('required', message: 'Masukkan role')]
    public $role;

    public function mount($id)
    {
        $data = User::find($id);

        $this->id   = $data->id;
        $this->name = $data->name;
        $this->phone = $data->phone;
        $this->email = $data->email;
        $this->role = $data->role;
    }
    public function store()
    {
        $this->validate();
        $data = User::find($this->id);

        $data->update([
            'phone' => $this->phone,
            'email' => $this->email,
            'name' => $this->name,
            'register_from' => "admin",
            'role' => $this->role
        ]);
        if (isset($this->password) && $this->password != NULL) {
            $data->update([
                'password' => Hash::make($this->password),
            ]);
        }

        session()->flash('message', 'Data Berhasil Diupdate.');
        $this->redirectRoute('admin.edit', $this->id, navigate: true);
    }
    public function render()
    {
        return view('livewire.dashboard.admin.edit');
    }
}
