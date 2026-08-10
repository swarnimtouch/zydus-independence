@extends('admin.layout')

@section('title', 'Zydus Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Quick overview of Independence Day registrations.')

@section('content')
  <section class="admin-stat-grid">
    <article class="admin-card admin-stat">
      <div class="admin-stat-label">Total Users</div>
      <div class="admin-stat-value">{{ $usersCount }}</div>
    </article>
  </section>
@endsection
