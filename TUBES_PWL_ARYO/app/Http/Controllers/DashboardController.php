<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        return view('dashboard', [
            'counts' => [
                'dosen' => Dosen::count(),
                'mahasiswa' => Mahasiswa::count(),
                'mataKuliah' => MataKuliah::count(),
                'jadwal' => Jadwal::count(),
                'krs' => $user->role === 'admin' ? Krs::count() : ($mahasiswa?->krs()->count() ?? 0),
            ],
            'jadwals' => Jadwal::with(['mataKuliah', 'dosen'])->latest()->limit(6)->get(),
            'krsSaya' => $mahasiswa
                ? $mahasiswa->krs()->with(['jadwal.mataKuliah', 'jadwal.dosen'])->latest()->limit(6)->get()
                : collect(),
        ]);
    }
}
