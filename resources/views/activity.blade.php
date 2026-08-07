<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Hoist The Flag</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body class="activity-page">

  <!-- NAYA ADD KIYA: Realistic Wave Filter Engine -->
  <svg width="0" height="0" style="position: absolute; z-index: -1; visibility: hidden;">
    <filter id="realistic-wave">
      <!-- Ye turbulence hawa ka effect (noise) banayega -->
      <feTurbulence id="wind-turbulence" type="fractalNoise" baseFrequency="0.01 0.1" numOctaves="2" result="noise" />
      <!-- Ye displacement image ko us noise ke hisab se hilaayega (wave karega) -->
      <feDisplacementMap in="SourceGraphic" in2="noise" scale="15" xChannelSelector="R" yChannelSelector="G" />
    </filter>
  </svg>

  <div class="brand-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" />

  </div>

  <div class="page-wrapper">
    <div class="container">
      <div class="row content-row">

        <!-- Left: Pole Stage -->
        <div class="col-12 col-md-6">
          <div class="flag-stage pole-stage" id="flagStage">
            <div class="pole-scene">
              <img src="{{ asset('images/pole_with_flag.png') }}" alt="Flag Pole"
                   class="pole-image" id="poleImage" />

              <img data-src="{{ asset('images/host.gif') }}" alt="Waving Flag"
                   class="host-gif is-hidden" id="hostGif" />
            </div>
          </div>
        </div>

        <!-- Right: Phase text panels -->
        <div class="col-12 col-md-6 d-flex align-items-center">

          <!-- Phase 1 / Slide 4 text -->
          <div class="activity-text activity-hero-text text-block" id="phase1Text">
            <span class="text-line lg dark-text">Hoist the flag to</span>
            <span class="text-line lg dark-text">celebrate the</span>
            <span class="text-line xl gold-gradient-text typewriter activity-golden-text">GOLDEN MOMENTS</span>
            <span class="text-line lg dark-text">of Indians through</span>
            <span class="text-line lg activity-purity-line">
              <span class="heartwise-text">HEART WISE</span>
              <span class="purity-text">PURITY</span>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Floating bubbles container -->
    <div class="bubbles-container" id="bubblesContainer"></div>

    <!-- Final message after bubbles -->
    <div class="activity-final-layout is-hidden" id="phase3Text">
      <div class="activity-final-top final-animate">
        Let's give every <span class="acs-red">ACS</span> patient the right to
      </div>

      <div class="activity-final-preserve final-animate">
        <span class="preserve-label">Preserve</span>
        <span class="text-line xl gold-gradient-text final-golden-text">
          <span class="final-typewriter-line final-golden-line">GOLDEN</span>
          <span class="final-typewriter-line final-moments-line">MOMENTS</span>
        </span>
      </div>

      <div class="activity-final-logo final-animate">
        <img src="{{ asset('images/atorva.png') }}" alt="Atorva Gold" />

      </div>

      <div class="activity-final-day final-animate">
        <span>HAPPY</span>
        <strong>INDEPENDENCE</strong>
        <span>DAY</span>
      </div>
    </div>

    <!-- Background music -->
    <!-- Background music (loop attribute added taaki chhota music auto-repeat ho) -->
    <audio id="bgAudio" src="{{ asset('images/audio.mp3') }}" preload="auto" loop></audio>


    <!-- Next button (Phase 3 tak hidden) -->
    <a href="{{ route('atorva.gold') }}" class="btn-next is-hidden" id="activityNextBtn">Next</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="{{ asset('js/activity.js') }}"></script>
</body>
</html>
