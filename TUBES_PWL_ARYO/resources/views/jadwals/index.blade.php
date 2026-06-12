@extends('layouts.app')

@section('title', 'Data Jadwal')

@section('content')
    <div class="topbar">
        <div><h1>Data Jadwal</h1><div class="sub">Daftar dosen pengajar, hari, jam, kelas, dan ruang.</div></div>
        @if(auth()->user()->role === 'admin')
            <a class="btn primary" href="{{ route('jadwals.create') }}">Tambah Jadwal</a>
        @else
            <a class="btn primary" href="{{ route('krs.create') }}">Ambil KRS</a>
        @endif
    </div>
    <div class="panel">
        <form class="actions" method="GET" style="margin-bottom:14px">
            <input name="q" value="{{ $search }}" placeholder="Cari jadwal, dosen, atau mata kuliah" style="max-width:360px">
            <button class="btn" type="submit">Cari</button>
        </form>
        <table>
            <thead><tr><th>Mata Kuliah</th><th>Dosen</th><th>Hari</th><th>Jam</th><th>Kelas</th><th>Ruang</th>@if(auth()->user()->role === 'admin')<th>Aksi</th>@endif</tr></thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->mataKuliah->kode }} - {{ $jadwal->mataKuliah->nama }}</td>
                        <td>{{ $jadwal->dosen->nama }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                        <td>{{ $jadwal->kelas }}</td>
                        <td>{{ $jadwal->ruang }}</td>
                        @if(auth()->user()->role === 'admin')
                            <td class="actions">
                                <a class="btn muted" href="{{ route('jadwals.edit', $jadwal) }}">Edit</a>
                                <form method="POST" action="{{ route('jadwals.destroy', $jadwal) }}" onsubmit="return confirm('Hapus jadwal ini?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}">Data belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $jadwals->links() }}</div>
    </div>
@endsection
