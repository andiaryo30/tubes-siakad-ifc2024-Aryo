@extends('layouts.app')

@section('title', 'Data Dosen')

@section('content')
    <div class="topbar">
        <div><h1>Data Dosen</h1><div class="sub">Kelola data pengajar.</div></div>
        <a class="btn primary" href="{{ route('dosens.create') }}">Tambah Dosen</a>
    </div>
    <div class="panel">
        <form class="actions" method="GET" style="margin-bottom:14px">
            <input name="q" value="{{ $search }}" placeholder="Cari nama atau NIDN" style="max-width:320px">
            <button class="btn" type="submit">Cari</button>
        </form>
        <table>
            <thead><tr><th>NIDN</th><th>Nama</th><th>Email</th><th>No HP</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($dosens as $dosen)
                    <tr>
                        <td>{{ $dosen->nidn }}</td><td>{{ $dosen->nama }}</td><td>{{ $dosen->email ?: '-' }}</td><td>{{ $dosen->no_hp ?: '-' }}</td>
                        <td class="actions">
                            <a class="btn muted" href="{{ route('dosens.edit', $dosen) }}">Edit</a>
                            <form method="POST" action="{{ route('dosens.destroy', $dosen) }}" onsubmit="return confirm('Hapus data dosen ini?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Data belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $dosens->links() }}</div>
    </div>
@endsection
