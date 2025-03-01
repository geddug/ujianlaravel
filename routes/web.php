<?php

use App\Http\Controllers\Upload;
use App\Livewire\Dashboard\Admin\Create;
use App\Livewire\Dashboard\Admin\Edit;
use App\Livewire\Dashboard\Admin\Index;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Mapel\Create as MapelCreate;
use App\Livewire\Dashboard\Mapel\Edit as MapelEdit;
use App\Livewire\Dashboard\Mapel\Index as MapelIndex;
use App\Livewire\Dashboard\Materi\Create as MateriCreate;
use App\Livewire\Dashboard\Materi\Edit as MateriEdit;
use App\Livewire\Dashboard\Materi\Index as MateriIndex;
use App\Livewire\Dashboard\Profile\Index as ProfileIndex;
use App\Livewire\Dashboard\Profile\Password;
use App\Livewire\Dashboard\Soal\Create as SoalCreate;
use App\Livewire\Dashboard\Soal\Edit as SoalEdit;
use App\Livewire\Dashboard\Soal\Index as SoalIndex;
use App\Livewire\Dashboard\Ujian\Create as UjianCreate;
use App\Livewire\Dashboard\Ujian\Edit as UjianEdit;
use App\Livewire\Dashboard\Ujian\Index as UjianIndex;
use App\Livewire\Homepage\Index as HomepageIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', HomepageIndex::class)->name('homepage');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware('auth')->group(function () {
    if (isset(Auth::user()->role) && Auth::user()->role == "siswa") {
        Route::get('dashboard', Dashboard::class)->name('dashboard')->middleware('verified');
    } else {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
    }

    Route::middleware('role:admin')->group(function () {
        Route::get('dashboard/admin', Index::class)->name('admin.index');
        Route::get('dashboard/admin/create', Create::class)->name('admin.create');
        Route::get('dashboard/admin/edit/{id}', Edit::class)->name('admin.edit');

        Route::get('dashboard/mapel', MapelIndex::class)->name('mapel.index');
        Route::get('dashboard/mapel/create', MapelCreate::class)->name('mapel.create');
        Route::get('dashboard/mapel/edit/{id}', MapelEdit::class)->name('mapel.edit');
    });

    Route::middleware('role:admin,guru')->group(function () {
        Route::get('dashboard/materi', MateriIndex::class)->name('materi.index');
        Route::get('dashboard/materi/create', MateriCreate::class)->name('materi.create');
        Route::get('dashboard/materi/edit/{id}', MateriEdit::class)->name('materi.edit');

        Route::get('dashboard/soal', SoalIndex::class)->name('soal.index');
        Route::get('dashboard/soal/create', SoalCreate::class)->name('soal.create');
        Route::get('dashboard/soal/edit/{id}', SoalEdit::class)->name('soal.edit');

        Route::get('dashboard/ujian', UjianIndex::class)->name('ujian.index');
        Route::get('dashboard/ujian/create', UjianCreate::class)->name('ujian.create');
        Route::get('dashboard/ujian/edit/{id}', UjianEdit::class)->name('ujian.edit');

        Route::any('uploader', [Upload::class, 'uploader'])->name('upload');
    });

    Route::get('dashboard/profile', ProfileIndex::class)->name('profile.index');
    Route::get('dashboard/password', Password::class)->name('profile.password');
});

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__ . '/auth.php';
