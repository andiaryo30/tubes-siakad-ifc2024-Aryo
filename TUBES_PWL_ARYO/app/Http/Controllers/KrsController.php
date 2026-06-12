<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $krs = Krs::with(['mahasiswa', 'jadwal.mataKuliah', 'jadwal.dosen'])
            ->when($user->role === 'mahasiswa', fn ($query) => $query->where('mahasiswa_id', $user->mahasiswa_id))
            ->latest()
            ->paginate(10);

        return view('krs.index', compact('krs'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $mahasiswaId = $user->role === 'mahasiswa' ? $user->mahasiswa_id : null;

        return view('krs.form', [
            'jadwals' => Jadwal::with(['mataKuliah', 'dosen'])->orderBy('hari')->orderBy('jam_mulai')->get(),
            'mahasiswas' => Mahasiswa::orderBy('nama')->get(),
            'mahasiswaId' => $mahasiswaId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            $request->validate([
                'mahasiswa_id' => ['required', 'exists:mahasiswas,id'],
            ]);
        }

        $mahasiswaId = $user->role === 'mahasiswa' ? $user->mahasiswa_id : $request->integer('mahasiswa_id');

        abort_if($mahasiswaId === null, 403);

        $data = $request->validate([
            'jadwal_id' => [
                'required',
                'exists:jadwals,id',
                Rule::unique('krs')->where(fn ($query) => $query->where('mahasiswa_id', $mahasiswaId)),
            ],
        ]);

        Krs::create([
            'mahasiswa_id' => $mahasiswaId,
            'jadwal_id' => $data['jadwal_id'],
        ]);

        return redirect()->route('krs.index')->with('success', 'Mata kuliah berhasil diambil.');
    }

    public function destroy(Request $request, Krs $kr): RedirectResponse
    {
        if ($request->user()->role === 'mahasiswa') {
            abort_unless((int) $request->user()->mahasiswa_id === (int) $kr->mahasiswa_id, 403);
        }

        $kr->delete();

        return back()->with('success', 'Mata kuliah berhasil di-drop.');
    }
}
