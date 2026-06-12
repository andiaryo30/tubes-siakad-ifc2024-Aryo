@extends('layouts.app')

@section('title', $mahasiswa->exists ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')

@section('content')
    <div class="topbar"><div><h1>{{ $mahasiswa->exists ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' }}</h1><div class="sub">Password kosong saat tambah akan memakai NIM sebagai password awal.</div></div></div>
    <form class="panel form-grid" method="POST" action="{{ $mahasiswa->exists ? route('mahasiswas.update', $mahasiswa) : route('mahasiswas.store') }}">
        @csrf
        @if($mahasiswa->exists) @method('PUT') @endif
        <div><label>NIM</label><input name="nim" value="{{ old('nim', $mahasiswa->nim) }}">@error('nim')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Nama</label><input name="nama" value="{{ old('nama', $mahasiswa->nama) }}">@error('nama')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Email</label><input name="email" type="email" value="{{ old('email', $mahasiswa->email) }}">@error('email')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Password Login</label><input name="password" type="password">@error('password')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Angkatan</label><input name="angkatan" type="number" value="{{ old('angkatan', $mahasiswa->angkatan ?: date('Y')) }}">@error('angkatan')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Kelas</label><input name="kelas" value="{{ old('kelas', $mahasiswa->kelas) }}">@error('kelas')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>No HP</label><input name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}">@error('no_hp')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full"><label>Alamat</label><textarea name="alamat" rows="3">{{ old('alamat', $mahasiswa->alamat) }}</textarea>@error('alamat')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full actions"><button class="btn primary" type="submit">Simpan</button><a class="btn" href="{{ route('mahasiswas.index') }}">Batal</a></div>
    </form>
@endsection
