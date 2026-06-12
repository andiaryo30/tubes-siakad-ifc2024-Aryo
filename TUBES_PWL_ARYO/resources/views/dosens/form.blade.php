@extends('layouts.app')

@section('title', $dosen->exists ? 'Edit Dosen' : 'Tambah Dosen')

@section('content')
    <div class="topbar"><div><h1>{{ $dosen->exists ? 'Edit Dosen' : 'Tambah Dosen' }}</h1><div class="sub">Lengkapi data dosen.</div></div></div>
    <form class="panel form-grid" method="POST" action="{{ $dosen->exists ? route('dosens.update', $dosen) : route('dosens.store') }}">
        @csrf
        @if($dosen->exists) @method('PUT') @endif
        <div><label>NIDN</label><input name="nidn" value="{{ old('nidn', $dosen->nidn) }}">@error('nidn')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Nama</label><input name="nama" value="{{ old('nama', $dosen->nama) }}">@error('nama')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Email</label><input name="email" type="email" value="{{ old('email', $dosen->email) }}">@error('email')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>No HP</label><input name="no_hp" value="{{ old('no_hp', $dosen->no_hp) }}">@error('no_hp')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full"><label>Alamat</label><textarea name="alamat" rows="3">{{ old('alamat', $dosen->alamat) }}</textarea>@error('alamat')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full actions"><button class="btn primary" type="submit">Simpan</button><a class="btn" href="{{ route('dosens.index') }}">Batal</a></div>
    </form>
@endsection
