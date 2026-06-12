<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIAKAD')</title>
    <style>
        :root { color-scheme: light; --ink:#1f2937; --muted:#6b7280; --line:#d7dde6; --bg:#f5f7fb; --panel:#fff; --primary:#166534; --accent:#0f766e; --danger:#b91c1c; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: var(--ink); background: var(--bg); }
        a { color: inherit; text-decoration: none; }
        .shell { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .side { background: #10231e; color: #eef8f2; padding: 22px 18px; }
        .brand { font-size: 22px; font-weight: 800; margin-bottom: 6px; }
        .role { color: #b8cec3; font-size: 13px; margin-bottom: 24px; }
        .nav { display: grid; gap: 8px; }
        .nav a, .logout { border: 0; width: 100%; display: block; padding: 11px 12px; border-radius: 8px; background: transparent; color: #eef8f2; text-align: left; font: inherit; cursor: pointer; }
        .nav a:hover, .logout:hover { background: rgba(255,255,255,.1); }
        .main { padding: 26px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 22px; }
        h1 { margin: 0; font-size: 28px; }
        .sub { color: var(--muted); margin-top: 5px; }
        .panel { background: var(--panel); border: 1px solid var(--line); border-radius: 8px; padding: 18px; }
        .grid { display: grid; gap: 16px; }
        .stats { grid-template-columns: repeat(5, minmax(120px, 1fr)); }
        .stat strong { display: block; font-size: 26px; margin-bottom: 4px; }
        .actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .btn { border: 1px solid var(--line); border-radius: 8px; padding: 9px 13px; background: #fff; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-size: 14px; }
        .btn.primary { background: var(--primary); border-color: var(--primary); color: #fff; }
        .btn.danger { background: var(--danger); border-color: var(--danger); color: #fff; }
        .btn.muted { background: #eef2f7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 10px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        th { font-size: 13px; color: var(--muted); text-transform: uppercase; letter-spacing: .02em; }
        input, select, textarea { width: 100%; border: 1px solid var(--line); border-radius: 8px; padding: 10px 11px; font: inherit; background: #fff; }
        label { display: block; font-weight: 700; margin-bottom: 7px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .full { grid-column: 1 / -1; }
        .alert { padding: 12px 14px; border-radius: 8px; margin-bottom: 16px; }
        .alert.success { background: #dcfce7; color: #14532d; }
        .alert.error { background: #fee2e2; color: #7f1d1d; }
        .error-text { color: var(--danger); font-size: 13px; margin-top: 6px; }
        .badge { display: inline-block; padding: 5px 8px; border-radius: 999px; background: #e7f3ef; color: #0f5132; font-size: 12px; font-weight: 700; }
        .pagination { margin-top: 16px; }
        @media (max-width: 900px) {
            .shell { grid-template-columns: 1fr; }
            .side { position: static; }
            .stats, .form-grid { grid-template-columns: 1fr; }
            .main { padding: 18px; }
            table { display: block; overflow-x: auto; white-space: nowrap; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="side">
            <div class="brand">SIAKAD</div>
            <div class="role">{{ auth()->user()->name ?? 'Guest' }} @auth - {{ strtoupper(auth()->user()->role) }} @endauth</div>
            @auth
                <nav class="nav">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dosens.index') }}">Dosen</a>
                        <a href="{{ route('mahasiswas.index') }}">Mahasiswa</a>
                        <a href="{{ route('mata-kuliahs.index') }}">Mata Kuliah</a>
                    @endif
                    <a href="{{ route('jadwals.index') }}">Jadwal</a>
                    <a href="{{ route('krs.index') }}">KRS</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout" type="submit">Logout</button>
                    </form>
                </nav>
            @endauth
        </aside>
        <main class="main">
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert error">Periksa kembali input yang belum valid.</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
