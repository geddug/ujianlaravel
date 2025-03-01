<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Password extends Component
{
    public $id;
    #[Rule('required', message: 'Masukkan password lama')]
    public $password;

    #[Rule('required', message: 'Masukkan password baru')]
    public $password_baru;

    #[Rule('required', message: 'Masukkan ulangi password')]
    public $re_password_baru;

    public function mount()
    {
        $data = User::find(Auth::user()->id);

        $this->id   = $data->id;
    }
    public function store()
    {
        $this->validate();
        $data = User::find($this->id);
        $plama = Hash::make($this->password);
        if (!Hash::check($this->password, Auth::user()->password)) {
            session()->flash('message', 'Password lama salah');
            $this->redirectRoute('profile.password', navigate: true);
        } else {
            if($this->password_baru != $this->re_password_baru) {
                session()->flash('message', 'Password baru tidak sama');
                $this->redirectRoute('profile.password', navigate: true);
            } else {
                $data->update([
                    'password' => Hash::make($this->password_baru),
                ]);
                session()->flash('message', 'Data Berhasil Diupdate.');
                $this->redirectRoute('profile.password', navigate: true);
            }
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.password');
    }
}
