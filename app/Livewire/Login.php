<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required', message: 'Masukkan email')]
    public $email;

    #[Rule('required', message: 'Masukkan password')]
    public $password;

    public function save()
    {
        $this->validate();

        $data = [
            'email' => $this->email,
            'password' => $this->password,
        ];
        if (Auth::Attempt($data)) {
            //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            $this->redirectRoute('dashboard', navigate: true);
        }else{
            session()->flash('message', 'email atau password salah');
            //$this->redirectRoute('login');
        }
    }

    public function render()
    {
        if(Auth::check()) {
            $this->redirectRoute('dashboard');
        }
        return view('livewire.login');
    }
}
