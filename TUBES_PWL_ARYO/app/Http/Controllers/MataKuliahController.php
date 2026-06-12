<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $mataKuliahs = MataKuliah::query()
            ->when($search, fn ($query) => $query->where('nama', 'like', "%{$search}%")->orWhere('kode', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mata-kuliahs.index', compact('mataKuliahs', 'search'));
    }

    public function create(): View
    {
        return view('mata-kuliahs.form', ['mataKuliah' => new MataKuliah()]);
    }

    public function store(Request $request): RedirectResponse
    {
        MataKuliah::create($this->validated($request));

        return redirect()->route('mata-kuliahs.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('mata-kuliahs.form', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->update($this->validated($request, $mataKuliah));

        return redirect()->route('mata-kuliahs.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->delete();

        return back()->with('success', 'Data mata kuliah berhasil dihapus.');
    }

    private function validated(Request $request, ?MataKuliah $mataKuliah = null): array
    {
        return $request->validate([
            'kode' => ['required', 'string', 'max:30', Rule::unique('mata_kuliahs')->ignore($mataKuliah)],
            'nama' => ['required', 'string', 'max:120'],
            'sks' => ['required', 'integer', 'between:1,6'],
            'semester' => ['required', 'integer', 'between:1,14'],
        ]);
    }
}
