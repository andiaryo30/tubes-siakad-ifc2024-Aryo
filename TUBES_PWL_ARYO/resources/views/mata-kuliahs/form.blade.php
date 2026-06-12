@extends('layouts.app')

@section('title', $mataKuliah->exists ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah')

@section('content')
    <div class="topbar"><div><h1>{{ $mataKuliah->exists ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}</h1><div class="sub">Lengkapi data akademik mata kuliah.</div></div></div>
    <form class="panel form-grid" method="POST" action="{{ $mataKuliah->exists ? route('mata-kuliahs.update', $mataKuliah) : route('mata-kuliahs.store') }}">
        @csrf
        @if($mataKuliah->exists) @method('PUT') @endif
        <div><label>Kode</label><input name="kode" value="{{ old('kode', $mataKuliah->kode) }}">@error('kode')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Nama</label><input name="nama" value="{{ old('nama', $mataKuliah->nama) }}">@error('nama')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>SKS</label><input name="sks" type="number" value="{{ old('sks', $mataKuliah->sks ?: 3) }}">@error('sks')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div><label>Semester</label><input name="semester" type="number" value="{{ old('semester', $mataKuliah->semester ?: 1) }}">@error('semester')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div class="full actions"><button class="btn primary" type="submit">Simpan</button><a class="btn" href="{{ route('mata-kuliahs.index') }}">Batal</a></div>
    </form>
@endsection
