@extends('layouts.app')

@section('title', 'KRS')

@section('content')
    <div class="topbar">
        <div><h1>Kartu Rencana Studi</h1><div class="sub">Daftar mata kuliah yang sudah diambil.</div></div>
        <a class="btn primary" href="{{ route('krs.create') }}">Ambil Mata Kuliah</a>
    </div>
    <div class="panel">
        <table>
            <thead><tr><th>Mahasiswa</th><th>Mata Kuliah</th><th>SKS</th><th>Dosen</th><th>Jadwal</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($krs as $item)
                    <tr>
                        <td>{{ $item->mahasiswa->nim }} - {{ $item->mahasiswa->nama }}</td>
                        <td>{{ $item->jadwal->mataKuliah->kode }} - {{ $item->jadwal->mataKuliah->nama }}</td>
                        <td>{{ $item->jadwal->mataKuliah->sks }}</td>
                        <td>{{ $item->jadwal->dosen->nama }}</td>
                        <td>{{ $item->jadwal->hari }}, {{ substr($item->jadwal->jam_mulai, 0, 5) }} - {{ substr($item->jadwal->jam_selesai, 0, 5) }} / {{ $item->jadwal->ruang }}</td>
                        <td>
                            <form method="POST" action="{{ route('krs.destroy', $item) }}" onsubmit="return confirm('Drop mata kuliah ini?')">@csrf @method('DELETE')<button class="btn danger">Drop</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Belum ada KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $krs->links() }}</div>
    </div>
@endsection
