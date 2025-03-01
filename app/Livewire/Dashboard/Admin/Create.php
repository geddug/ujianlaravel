<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required', message: 'Masukkan nama')]
    public $name;

    #[Rule('required', message: 'Masukkan email')]
    public $email;

    #[Rule('required', message: 'Masukkan telp')]
    public $phone;

    #[Rule('required', message: 'Masukkan password')]
    public $password;

    #[Rule('required', message: 'Masukkan role')]
    public $role;

    public function store()
    {
        $this->validate();
        $check = User::where('email', $this->email)->exists();
        if ($check) {
            session()->flash('message', 'Email sudah terdaftar');
            $this->redirectRoute('register');
        } else {
            User::create([
                'phone' => $this->phone,
                'email' => $this->email,
                'name' => $this->name,
                'password' => Hash::make($this->password),
                'register_from' => "admin",
                'role' => $this->role
            ]);
            session()->flash('message', 'Data Berhasil Disimpan.');

            $this->redirectRoute('admin.create', navigate: true);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.admin.create');
    }
}
