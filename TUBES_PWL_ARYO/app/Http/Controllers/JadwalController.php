<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $jadwals = Jadwal::with(['mataKuliah', 'dosen'])
            ->when($search, function ($query) use ($search): void {
                $query->where('kelas', 'like', "%{$search}%")
                    ->orWhere('hari', 'like', "%{$search}%")
                    ->orWhereHas('mataKuliah', fn ($sub) => $sub->where('nama', 'like', "%{$search}%")->orWhere('kode', 'like', "%{$search}%"))
                    ->orWhereHas('dosen', fn ($sub) => $sub->where('nama', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('jadwals.index', compact('jadwals', 'search'));
    }

    public function create(): View
    {
        return $this->form(new Jadwal());
    }

    public function store(Request $request): RedirectResponse
    {
        Jadwal::create($this->validated($request));

        return redirect()->route('jadwals.index')->with('success', 'Data jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal): View
    {
        return $this->form($jadwal);
    }

    public function update(Request $request, Jadwal $jadwal): RedirectResponse
    {
        $jadwal->update($this->validated($request));

        return redirect()->route('jadwals.index')->with('success', 'Data jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return back()->with('success', 'Data jadwal berhasil dihapus.');
    }

    private function form(Jadwal $jadwal): View
    {
        return view('jadwals.form', [
            'jadwal' => $jadwal,
            'dosens' => Dosen::orderBy('nama')->get(),
            'mataKuliahs' => MataKuliah::orderBy('nama')->get(),
            'haris' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
            'dosen_id' => ['required', 'exists:dosens,id'],
            'hari' => ['required', 'string', 'max:20'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'kelas' => ['required', 'string', 'max:30'],
            'ruang' => ['required', 'string', 'max:30'],
        ]);
    }
}
