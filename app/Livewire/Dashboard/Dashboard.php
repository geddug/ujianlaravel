<?php

namespace App\Livewire\Dashboard;

use App\Models\Tryout;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $ujian = array();
        $tryout = array();
        if(Auth::user()->role == 'siswa') {
            $ujian = Ujian::with('mapel')->where('status','yes')->orderBy('id','desc')->get();
            $tryout = Tryout::with('mapel')->where('status','yes')->orderBy('id','desc')->get();
        }
        return view('livewire.dashboard.dashboard',[
            'ujian' => $ujian,
            'tryout' => $tryout
        ]);
    }
}
