<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Zydus | The First Golden Moment</title>

  <link rel="preload" as="image" href="{{ asset('images/logo.png') }}" />
  <link rel="preload" as="image" href="{{ asset('images/freedom-fighters.png') }}" />
  <link rel="preload" as="image" href="{{ asset('images/desktop_2.png') }}" media="(min-width: 768px)" />
  <link rel="preload" as="image" href="{{ asset('images/mobile_2.png') }}" media="(max-width: 767px)" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<!-- body me bg-slide-2 class add ki -->
<body class="bg-slide-2">

  <div class="brand-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" loading="eager" decoding="async" fetchpriority="high" />
  </div>

  <div class="page-wrapper">
    <div class="container">
      <div class="row content-row">

        <!-- Left: Freedom Fighters Photo -->
        <div class="col-12 col-md-6 text-center mb-4 mb-md-0">
          <div class="image-frame">
            <img src="{{ asset('images/freedom-fighters.png') }}" alt="Freedom Fighters" loading="eager" decoding="async" fetchpriority="high" />
          </div>
        </div>

        <!-- Right: Staggered animated text -->
        <div class="col-12 col-md-6 text-block" id="textContainer">
          <!-- Dark text with specific bold words -->
          <span class="text-line lg dark-text">They gave us the <span class="bold-word">first</span></span>
          <!-- Gold gradient text with Typewriter class -->
          <span class="text-line xl gold-gradient-text typewriter golden-two-line">
            <span class="golden-word">GOLDEN</span>
            <span class="golden-word">MOMENT</span>
          </span>
          <span class="text-line lg dark-text">of <span class="bold-word">Indian History</span>.</span>
          <!-- Modern Brownish-Golden Date Badge -->
          <div class="date-badge">15<sup>TH</sup> AUG 1947</div>
        </div>

      </div>
    </div>

    <!-- Arrow button to third slide -->
    <a href="{{ route('third') }}" class="btn-next" aria-label="Continue"><span aria-hidden="true">&gt;&gt;</span></a>
  </div>

  <script src="{{ asset('js/viewport-fit.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="{{ asset('js/second.js') }}"></script>
</body>
</html>
