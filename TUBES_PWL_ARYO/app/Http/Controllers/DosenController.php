<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $dosens = Dosen::query()
            ->when($search, fn ($query) => $query->where('nama', 'like', "%{$search}%")->orWhere('nidn', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dosens.index', compact('dosens', 'search'));
    }

    public function create(): View
    {
        return view('dosens.form', ['dosen' => new Dosen()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Dosen::create($this->validated($request));

        return redirect()->route('dosens.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen): View
    {
        return view('dosens.form', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $dosen->update($this->validated($request, $dosen));

        return redirect()->route('dosens.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $dosen->delete();

        return back()->with('success', 'Data dosen berhasil dihapus.');
    }

    private function validated(Request $request, ?Dosen $dosen = null): array
    {
        return $request->validate([
            'nidn' => ['required', 'string', 'max:30', Rule::unique('dosens')->ignore($dosen)],
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:120', Rule::unique('dosens')->ignore($dosen)],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
