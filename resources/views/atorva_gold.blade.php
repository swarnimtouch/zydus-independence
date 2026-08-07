<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Atorva Gold</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="atorva-page">

  <main class="atorva-slide">
    <picture class="atorva-picture">
      <source media="(min-width: 768px) and (max-width: 1366px) and (orientation: portrait)" srcset="{{ asset('images/atorva_tab_portrait.png') }}" />
      <source media="(min-width: 768px) and (max-width: 1366px) and (orientation: landscape)" srcset="{{ asset('images/atorva_tab_bg.png') }}" />
      <source media="(min-width: 1025px)" srcset="{{ asset('images/atorva_desktop_bg.png') }}" />
      <img src="{{ asset('images/atorva_mobile_bg.png') }}" alt="Atorva Gold" class="atorva-bg-image" />
    </picture>

    <a href="{{ route('form.create') }}" class="btn-next" aria-label="Continue"><span aria-hidden="true">&gt;&gt;</span></a>
  </main>

  <script src="{{ asset('js/AtorvaGold.js') }}"></script>

</body>
</html>
