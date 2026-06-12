@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
    <div class="topbar">
        <div><h1>Data Mata Kuliah</h1><div class="sub">Kelola daftar mata kuliah.</div></div>
        <a class="btn primary" href="{{ route('mata-kuliahs.create') }}">Tambah Mata Kuliah</a>
    </div>
    <div class="panel">
        <form class="actions" method="GET" style="margin-bottom:14px">
            <input name="q" value="{{ $search }}" placeholder="Cari kode atau nama" style="max-width:320px">
            <button class="btn" type="submit">Cari</button>
        </form>
        <table>
            <thead><tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($mataKuliahs as $mataKuliah)
                    <tr>
                        <td>{{ $mataKuliah->kode }}</td><td>{{ $mataKuliah->nama }}</td><td>{{ $mataKuliah->sks }}</td><td>{{ $mataKuliah->semester }}</td>
                        <td class="actions">
                            <a class="btn muted" href="{{ route('mata-kuliahs.edit', $mataKuliah) }}">Edit</a>
                            <form method="POST" action="{{ route('mata-kuliahs.destroy', $mataKuliah) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Data belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $mataKuliahs->links() }}</div>
    </div>
@endsection
