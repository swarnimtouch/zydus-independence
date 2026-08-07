<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | The First Golden Moment</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<!-- body me bg-slide-2 class add ki -->
<body class="bg-slide-2">

  <div class="brand-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" />
  </div>

  <div class="page-wrapper">
    <div class="container">
      <div class="row content-row">

        <!-- Left: Freedom Fighters Photo -->
        <div class="col-12 col-md-6 text-center mb-4 mb-md-0">
          <div class="image-frame">
            <img src="{{ asset('images/freedom-fighters.png') }}" alt="Freedom Fighters" />
          </div>
        </div>

        <!-- Right: Staggered animated text -->
        <div class="col-12 col-md-6 text-block" id="textContainer">
          <!-- Dark text with specific bold words -->
          <span class="text-line lg dark-text">They gave us the <span class="bold-word">first</span></span>
          <!-- Gold gradient text with Typewriter class -->
          <span class="text-line xl gold-gradient-text typewriter">GOLDEN MOMENT</span>
          <span class="text-line lg dark-text">of <span class="bold-word">Indian History</span>.</span>
          <!-- Modern Brownish-Golden Date Badge -->
          <div class="date-badge">15<sup>TH</sup> AUG 1947</div>
        </div>

      </div>
    </div>

    <!-- Next button → third.html -->
    <a href="{{route('third')}}" class="btn-next">Next</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="{{ asset('js/second.js') }}"></script>
</body>
</html>