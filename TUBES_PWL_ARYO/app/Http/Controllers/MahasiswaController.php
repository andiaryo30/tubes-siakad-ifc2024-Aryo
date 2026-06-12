<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $mahasiswas = Mahasiswa::query()
            ->when($search, fn ($query) => $query->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswas.index', compact('mahasiswas', 'search'));
    }

    public function create(): View
    {
        return view('mahasiswas.form', ['mahasiswa' => new Mahasiswa()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $password = $data['password'] ?: $data['nim'];
        unset($data['password']);

        $mahasiswa = Mahasiswa::create($data);

        User::create([
            'name' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'password' => Hash::make($password),
            'role' => 'mahasiswa',
            'mahasiswa_id' => $mahasiswa->id,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Data mahasiswa dan akun login berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswas.form', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $data = $this->validated($request, $mahasiswa);
        $password = $data['password'] ?? null;
        unset($data['password']);

        $mahasiswa->update($data);
        $user = $mahasiswa->user;

        if ($user) {
            $user->fill([
                'name' => $mahasiswa->nama,
                'email' => $mahasiswa->email,
            ]);

            if ($password) {
                $user->password = Hash::make($password);
            }

            $user->save();
        }

        return redirect()->route('mahasiswas.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->user?->delete();
        $mahasiswa->delete();

        return back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validated(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        return $request->validate([
            'nim' => ['required', 'string', 'max:30', Rule::unique('mahasiswas')->ignore($mahasiswa)],
            'nama' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('mahasiswas')->ignore($mahasiswa),
                Rule::unique('users')->ignore($mahasiswa?->user),
            ],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'kelas' => ['required', 'string', 'max:30'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'password' => [$mahasiswa ? 'nullable' : 'nullable', 'string', 'min:6', 'max:100'],
        ]);
    }
}
