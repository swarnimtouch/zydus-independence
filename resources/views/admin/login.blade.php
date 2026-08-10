<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Zydus Admin Login</title>
  <link rel="preload" as="image" href="{{ asset('images/logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body.admin-login-page {
      min-height: 100dvh;
      background: #f8fafc;
      display: grid;
      place-items: center;
      padding: 24px;
    }

    .admin-login-card {
      width: min(100%, 420px);
      background: rgba(255, 255, 255, .96);
      border: 1px solid rgba(214, 177, 46, .35);
      border-radius: 18px;
      box-shadow: 0 18px 48px rgba(15, 23, 42, .14);
      padding: clamp(24px, 4vw, 36px);
    }

    .admin-login-logo {
      display: block;
      width: 170px;
      max-width: 60%;
      margin: 0 auto 22px;
    }

    .admin-login-title {
      color: #020878;
      font-weight: 800;
      text-align: center;
      margin-bottom: 22px;
    }

    .admin-login-btn {
      width: 100%;
      border: 0;
      border-radius: 999px;
      color: #fff;
      font-weight: 800;
      letter-spacing: .08em;
      padding: 13px 18px;
      background: linear-gradient(120deg, #f7a42d, #d8bd2d, #139d16);
    }
  </style>
</head>
<body class="admin-login-page">
  <main class="admin-login-card">
    <img class="admin-login-logo" src="{{ asset('images/logo.png') }}" alt="Zydus">
    <h1 class="h3 admin-login-title">Admin Login</h1>

    <form method="POST" action="{{ route('admin.login.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button class="admin-login-btn" type="submit">LOGIN</button>
    </form>
  </main>
</body>
</html>
