@extends('layouts.app')

@section('title', 'Dashboard SIAKAD')

@section('content')
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>
            <div class="sub">Ringkasan Sistem Informasi Akademik.</div>
        </div>
    </div>

    <div class="grid stats">
        <div class="panel stat"><strong>{{ $counts['dosen'] }}</strong><span>Dosen</span></div>
        <div class="panel stat"><strong>{{ $counts['mahasiswa'] }}</strong><span>Mahasiswa</span></div>
        <div class="panel stat"><strong>{{ $counts['mataKuliah'] }}</strong><span>Mata Kuliah</span></div>
        <div class="panel stat"><strong>{{ $counts['jadwal'] }}</strong><span>Jadwal</span></div>
        <div class="panel stat"><strong>{{ $counts['krs'] }}</strong><span>KRS</span></div>
    </div>

    <div class="panel" style="margin-top:16px">
        <div class="topbar">
            <div>
                <h1 style="font-size:20px">Jadwal Terbaru</h1>
                <div class="sub">Daftar perkuliahan yang tersedia.</div>
            </div>
            <a class="btn primary" href="{{ route('krs.create') }}">Ambil KRS</a>
        </div>
        <table>
            <thead><tr><th>Mata Kuliah</th><th>Dosen</th><th>Hari</th><th>Jam</th><th>Kelas</th><th>Ruang</th></tr></thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->mataKuliah->kode }} - {{ $jadwal->mataKuliah->nama }}</td>
                        <td>{{ $jadwal->dosen->nama }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                        <td>{{ $jadwal->kelas }}</td>
                        <td>{{ $jadwal->ruang }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
