@extends('layouts.app')

@section('title', 'Ambil KRS')

@section('content')
    <div class="topbar"><div><h1>Ambil Mata Kuliah</h1><div class="sub">Pilih jadwal yang ingin dimasukkan ke KRS.</div></div></div>
    <form class="panel form-grid" method="POST" action="{{ route('krs.store') }}">
        @csrf
        @if(auth()->user()->role === 'admin')
            <div>
                <label>Mahasiswa</label>
                <select name="mahasiswa_id">
                    <option value="">Pilih mahasiswa</option>
                    @foreach($mahasiswas as $mahasiswa)
                        <option value="{{ $mahasiswa->id }}" @selected(old('mahasiswa_id', $mahasiswaId) == $mahasiswa->id)>{{ $mahasiswa->nim }} - {{ $mahasiswa->nama }}</option>
                    @endforeach
                </select>
                @error('mahasiswa_id')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        @endif
        <div class="{{ auth()->user()->role === 'admin' ? '' : 'full' }}">
            <label>Jadwal</label>
            <select name="jadwal_id">
                <option value="">Pilih jadwal</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}" @selected(old('jadwal_id') == $jadwal->id)>
                        {{ $jadwal->mataKuliah->kode }} - {{ $jadwal->mataKuliah->nama }} / {{ $jadwal->dosen->nama }} / {{ $jadwal->hari }} {{ substr($jadwal->jam_mulai, 0, 5) }} / {{ $jadwal->kelas }}
                    </option>
                @endforeach
            </select>
            @error('jadwal_id')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="full actions"><button class="btn primary" type="submit">Ambil</button><a class="btn" href="{{ route('krs.index') }}">Batal</a></div>
    </form>
@endsection
