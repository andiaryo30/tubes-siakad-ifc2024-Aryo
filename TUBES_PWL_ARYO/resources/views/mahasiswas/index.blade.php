@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
    <div class="topbar">
        <div><h1>Data Mahasiswa</h1><div class="sub">Kelola profil dan akun login mahasiswa.</div></div>
        <a class="btn primary" href="{{ route('mahasiswas.create') }}">Tambah Mahasiswa</a>
    </div>
    <div class="panel">
        <form class="actions" method="GET" style="margin-bottom:14px">
            <input name="q" value="{{ $search }}" placeholder="Cari nama atau NIM" style="max-width:320px">
            <button class="btn" type="submit">Cari</button>
        </form>
        <table>
            <thead><tr><th>NIM</th><th>Nama</th><th>Email</th><th>Kelas</th><th>Angkatan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td>{{ $mahasiswa->nim }}</td><td>{{ $mahasiswa->nama }}</td><td>{{ $mahasiswa->email }}</td><td>{{ $mahasiswa->kelas }}</td><td>{{ $mahasiswa->angkatan }}</td>
                        <td class="actions">
                            <a class="btn muted" href="{{ route('mahasiswas.edit', $mahasiswa) }}">Edit</a>
                            <form method="POST" action="{{ route('mahasiswas.destroy', $mahasiswa) }}" onsubmit="return confirm('Hapus mahasiswa dan akun loginnya?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Data belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $mahasiswas->links() }}</div>
    </div>
@endsection
