<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Zydus | Independence Day 2026 — Welcome</title>

  <link rel="preload" as="image" href="{{ asset('images/logo.png') }}" />
  <link rel="preload" as="image" href="{{ asset('images/desktop.png') }}" media="(min-width: 768px)" />
  <link rel="preload" as="image" href="{{ asset('images/mobile.png') }}" media="(max-width: 767px)" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Global stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body class="form-page">

  <!-- Zydus Logo -->
  <div class="brand-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" loading="eager" decoding="async" fetchpriority="high" />
  </div>

  <!-- Page Content -->
  <div class="page-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

          <div class="form-card">
            <div class="form-card-logo">
              <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" loading="eager" decoding="async" />
            </div>
            <h1 class="form-title">Independence Day 2026</h1>
            <p class="form-subtitle">ZYDUS • 15<sup>TH</sup> AUGUST CELEBRATION</p>

              <form id="welcomeForm" action="{{ route('form.store') }}" method="POST" novalidate>
                  @csrf

                  <div class="mb-3">
                      <label class="form-label-custom">BO Code</label>
                      <input type="text" id="bo_code" name="bo_code"
                             class="form-control-custom" placeholder="Enter BO Code">
                      <small id="bo_codeError" class="text-danger"></small>
                  </div>

                  <div class="mb-3">
                      <label class="form-label-custom">Doctor Code</label>
                      <input type="text" id="doctor_code" name="doctor_code"
                             class="form-control-custom" placeholder="Enter Doctor Code">
                      <small id="doctor_codeError" class="text-danger"></small>
                  </div>

                  <div class="mb-3">
                      <label class="form-label-custom">Name</label>
                      <input type="text" id="name" name="name"
                             class="form-control-custom" placeholder="Enter Name">
                      <small id="nameError" class="text-danger"></small>
                  </div>

                  <button type="submit" class="btn-submit">
                      Submit
                  </button>
              </form>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/viewport-fit.js') }}"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- jQuery Validation Plugin -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
  <!-- Page Script -->
    <script src="{{ asset('js/index.js') }}"></script>

</body>
</html>
