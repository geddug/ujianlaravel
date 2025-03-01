<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $isHidden = false;
    public function sendVerification()
    {
        $this->isHidden = !$this->isHidden;
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        session()->flash('status', 'verification-link-sent');
    }
    public function render()
    {
        return view('livewire.verify-email');
    }
}
