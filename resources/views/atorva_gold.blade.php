<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Zydus | Atorva Gold</title>

  <link rel="preload" as="image" href="{{ asset('images/atorva_desktop_bg.png') }}" media="(min-width: 1025px)" />
  <link rel="preload" as="image" href="{{ asset('images/atorva_tab_portrait.png') }}" media="(min-width: 768px) and (max-width: 1366px) and (orientation: portrait)" />
  <link rel="preload" as="image" href="{{ asset('images/atorva_tab_bg.png') }}" media="(min-width: 768px) and (max-width: 1366px) and (orientation: landscape)" />
  <link rel="preload" as="image" href="{{ asset('images/atorva_mobile_bg.png') }}" media="(max-width: 767px)" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="atorva-page">

  <main class="atorva-slide">
    <picture class="atorva-picture">
      <source media="(min-width: 768px) and (max-width: 1366px) and (orientation: portrait)" srcset="{{ asset('images/atorva_tab_portrait.png') }}" />
      <source media="(min-width: 768px) and (max-width: 1366px) and (orientation: landscape)" srcset="{{ asset('images/atorva_tab_bg.png') }}" />
      <source media="(min-width: 1025px)" srcset="{{ asset('images/atorva_desktop_bg.png') }}" />
      <img src="{{ asset('images/atorva_mobile_bg.png') }}" alt="Atorva Gold" class="atorva-bg-image" loading="eager" decoding="async" fetchpriority="high" />
    </picture>

    <a href="{{ route('certificate.generate') }}" class="btn-next atorva-certificate-btn" aria-label="Generate Certificate"><span>Generate Certificate</span></a>
  </main>

  <script src="{{ asset('js/viewport-fit.js') }}"></script>
  <script src="{{ asset('js/AtorvaGold.js') }}"></script>

</body>
</html>
