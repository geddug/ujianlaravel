<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule('required', message: 'Masukkan email')]
    public $email;

    #[Rule('required', message: 'Masukkan password')]
    public $password;

    #[Rule('required', message: 'Masukkan Nama')]
    public $name;

    public function save()
    {
        $this->validate();

        $check = User::where('email',$this->email)->exists();
        if($check) {
            session()->flash('message', 'Email sudah terdaftar');
            //$this->redirectRoute('register');
        } else {
            $checkadmin = User::where('role','admin')->get();
            $role = 'siswa';
            if($checkadmin->count() == 0) {
                $role = 'admin';
            }

            
            event(new Registered(
                $user = User::create([
                    'phone' => "",
                    'email' => $this->email,
                    'name' => $this->name,
                    'password' => Hash::make($this->password),
                    'register_from' => "register",
                    'role' => $role
                ])
            ));

            Auth::login($user);

            $this->redirect(route('dashboard', absolute: false), navigate: true);
            //session()->flash('message', 'Pendaftaran Berhasil.');
            //$this->redirectRoute('register');
        }
    }
    public function render()
    {
        if(Auth::check()) {
            $this->redirectRoute('dashboard');
        }
        return view('livewire.register');
    }
}
