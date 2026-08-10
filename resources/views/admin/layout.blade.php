<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Zydus Admin')</title>
  <link rel="preload" as="image" href="{{ asset('images/logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('head')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    html,
    body.admin-panel-page {
      min-height: 100%;
      overflow-x: hidden;
    }

    body.admin-panel-page {
      min-height: 100dvh;
      background: #f4f7fb;
      color: #111827;
      overflow-y: auto;
      font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .admin-app {
      display: grid;
      grid-template-columns: 280px minmax(0, 1fr);
      min-height: 100dvh;
    }

    .admin-sidebar {
      position: sticky;
      top: 0;
      height: 100dvh;
      background: #0f172a;
      color: #dbeafe;
      padding: 22px 18px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    .admin-brand {
      display: flex;
      align-items: center;
      padding: 10px 8px 24px;
      border-bottom: 1px solid rgba(255, 255, 255, .1);
      margin-bottom: 18px;
    }

    .admin-brand img {
      width: 132px;
      max-width: 78%;
      display: block;
    }

    .admin-nav {
      display: grid;
      gap: 8px;
    }

    .admin-nav-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 13px 14px;
      color: #cbd5e1;
      text-decoration: none;
      border-radius: 10px;
      font-weight: 700;
      transition: background .2s ease, color .2s ease;
    }

    .admin-nav-link:hover,
    .admin-nav-link.is-active {
      color: #fff;
      background: rgba(255, 255, 255, .12);
    }

    .admin-sidebar-footer {
      margin-top: auto;
      padding-top: 18px;
    }

    .admin-logout-form {
      margin: 0;
    }

    .admin-logout-btn {
      width: 100%;
      border: 0;
      border-radius: 10px;
      background: #dc2626;
      color: #fff;
      font-weight: 800;
      padding: 12px 14px;
      min-height: 44px;
    }

    .admin-main {
      min-width: 0;
      padding: clamp(18px, 2.6vw, 34px);
    }

    .admin-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      margin-bottom: 22px;
    }

    .admin-page-title {
      margin: 0;
      color: #0f172a;
      font-size: clamp(26px, 3vw, 38px);
      font-weight: 800;
    }

    .admin-page-subtitle {
      margin: 5px 0 0;
      color: #64748b;
      font-size: 14px;
    }

    .admin-header-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .admin-btn {
      border: 0;
      border-radius: 10px;
      font-weight: 800;
      padding: 10px 16px;
      min-height: 42px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      white-space: nowrap;
    }

    .admin-btn-green {
      color: #fff;
      background: #16a34a;
      box-shadow: 0 10px 22px rgba(22, 163, 74, .22);
    }

    .admin-btn-blue {
      color: #fff;
      background: #020878;
    }

    .admin-btn-muted {
      color: #0f172a;
      background: #e2e8f0;
    }

    .admin-btn-danger {
      color: #fff;
      background: #dc2626;
    }

    .admin-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      box-shadow: 0 12px 32px rgba(15, 23, 42, .08);
    }

    .admin-card-body {
      padding: clamp(18px, 2vw, 26px);
    }

    .admin-stat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 320px));
      gap: 18px;
      margin-bottom: 22px;
    }

    .admin-stat {
      padding: clamp(20px, 2.4vw, 30px);
    }

    .admin-stat-label {
      color: #64748b;
      font-size: 14px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .04em;
    }

    .admin-stat-value {
      color: #020878;
      font-size: clamp(38px, 5vw, 62px);
      font-weight: 900;
      line-height: 1;
      margin-top: 14px;
    }

    .admin-table-wrap {
      overflow-x: auto;
    }

    table.dataTable {
      width: 100% !important;
    }

    .admin-certificate-link {
      color: #020878;
      font-weight: 800;
      text-decoration: none;
    }

    .admin-certificate-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 991px) {
      .admin-app {
        display: block;
      }

      .admin-sidebar {
        position: relative;
        height: auto;
        min-height: auto;
        padding: 14px;
      }

      .admin-brand {
        padding-bottom: 14px;
        margin-bottom: 12px;
      }

      .admin-nav {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .admin-sidebar-footer {
        margin-top: 14px;
        padding-top: 0;
      }

      .admin-main {
        padding: 18px 14px 28px;
      }
    }

    @media (max-width: 640px) {
      .admin-header {
        align-items: flex-start;
        flex-direction: column;
      }

      .admin-header-actions {
        justify-content: flex-start;
        width: 100%;
      }

      .admin-stat-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
  @stack('styles')
</head>
<body class="admin-panel-page">
  <div class="admin-app">
    <aside class="admin-sidebar">
      <div class="admin-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Zydus">
      </div>

      <nav class="admin-nav">
        <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
          <span>Dashboard</span>
        </a>
        <a class="admin-nav-link {{ request()->routeIs('admin.users') ? 'is-active' : '' }}" href="{{ route('admin.users') }}">
          <span>Users</span>
        </a>
      </nav>

      <div class="admin-sidebar-footer">
        <form class="admin-logout-form" method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button class="admin-logout-btn" type="submit">Logout</button>
        </form>
      </div>
    </aside>

    <main class="admin-main">
      <header class="admin-header">
        <div>
          <h1 class="admin-page-title">@yield('page_title')</h1>
          <p class="admin-page-subtitle">@yield('page_subtitle')</p>
        </div>

        <div class="admin-header-actions">
          @yield('page_actions')
        </div>
      </header>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @yield('content')
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
