<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login SIAKAD</title>
    <style>
        body { margin:0; min-height:100vh; display:grid; place-items:center; font-family:Arial, Helvetica, sans-serif; background:#f4f7fb; color:#1f2937; }
        .card { width:min(420px, calc(100vw - 32px)); background:#fff; border:1px solid #d7dde6; border-radius:8px; padding:28px; }
        h1 { margin:0 0 8px; font-size:28px; }
        p { margin:0 0 22px; color:#6b7280; }
        label { display:block; font-weight:700; margin:14px 0 7px; }
        input { width:100%; border:1px solid #d7dde6; border-radius:8px; padding:11px; font:inherit; box-sizing:border-box; }
        button { width:100%; border:0; border-radius:8px; padding:12px; background:#166534; color:#fff; font-weight:700; margin-top:18px; cursor:pointer; }
        .error { color:#b91c1c; font-size:13px; margin-top:6px; }
        .hint { margin-top:18px; padding:12px; background:#eef7f2; border-radius:8px; color:#14532d; font-size:14px; }
    </style>
</head>
<body>
    <form class="card" method="POST" action="{{ route('login.store') }}">
        @csrf
        <h1>SIAKAD</h1>
        <p>Masuk untuk mengelola data akademik.</p>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
        @error('email') <div class="error">{{ $message }}</div> @enderror
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror
        <button type="submit">Login</button>
        <div class="hint">Demo admin: admin@siakad.test / password</div>
    </form>
</body>
</html>
