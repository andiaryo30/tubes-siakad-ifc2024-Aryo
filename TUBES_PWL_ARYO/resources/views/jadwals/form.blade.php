@extends('layouts.app')

@section('title', $jadwal->exists ? 'Edit Jadwal' : 'Tambah Jadwal')

@section('content')
    <div class="topbar"><div><h1>{{ $jadwal->exists ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h1><div class="sub">Pilih relasi dosen dan mata kuliah.</div></div></div>
    <form class="panel form-grid" method="POST" action="{{ $jadwal->exists ? route('jadwals.update', $jadwal) : route('jadwals.store') }}">
        @csrf
        @if($jadwal->exists) @method('PUT') @endif
        <div>
            <label>Mata Kuliah</label>
            <select name="mata_kuliah_id">
                <option value="">Pilih mata kuliah</option>
                @foreach($mataKuliahs as $mataKuliah)
                    <option value="{{ $mataKuliah->id }}" @selected(old('mata_kuliah_id', $jadwal->mata_kuliah_id) == $mataKuliah->id)>{{ $mataKuliah->kode }} - {{ $mataKuliah->nama }}</option>
                @endforeach
            </select>
            @error('mata_kuliah_id')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Dosen</label>
            <select name="dosen_id">
                <option value="">Pilih dosen</option>
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}" @selected(old('dosen_id', $jadwal->dosen_id) == $dosen->id)>{{ $dosen->nama }}</option>
                @endforeach
            </select>
            @error('dosen_id')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Hari</label>
            <select name="hari">
                <option value="">Pilih hari</option>
                @foreach($haris as $hari)
                    <option value="{{ $hari }}" @selected(old('hari', $jadwal->hari) === $hari)>{{ $hari }}</option>
                @endforeach
            </select>
            @error('hari')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div><label>Kelas</label><input name="kelas" value="{{ old('kelas', $jadwal->kelas) }}">@error('kelas')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Jam Mulai</label><input name="jam_mulai" type="time" value="{{ old('jam_mulai', $jadwal->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '') }}">@error('jam_mulai')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Jam Selesai</label><input name="jam_selesai" type="time" value="{{ old('jam_selesai', $jadwal->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '') }}">@error('jam_selesai')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Ruang</label><input name="ruang" value="{{ old('ruang', $jadwal->ruang) }}">@error('ruang')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full actions"><button class="btn primary" type="submit">Simpan</button><a class="btn" href="{{ route('jadwals.index') }}">Batal</a></div>
    </form>
@endsection
