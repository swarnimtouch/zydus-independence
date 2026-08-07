<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Certificate</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="certificate-page">

  <main class="certificate-page-wrap">
    <section class="certificate-shell" aria-label="Certificate preview">
      <div class="certificate-sheet">
        <img src="{{ asset('images/Certificate.jpg') }}" alt="Certificate" class="certificate-bg" />
        <img src="{{ asset($user->photo) }}" alt="{{ $user->name }}" class="certificate-user-photo" />
        <div class="certificate-user-name">{{ $user->name }}</div>
      </div>
    </section>

    <div class="certificate-actions">
      <a href="{{ route('certificate.download') }}" class="certificate-action-btn certificate-download-btn">
        Download
      </a>
      <a href="{{ route('form.create') }}" class="certificate-action-btn certificate-register-btn">
        New Register
      </a>
    </div>
  </main>

</body>
</html>
