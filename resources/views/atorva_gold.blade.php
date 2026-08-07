<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Atorva Gold</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="atorva-page">

  <main class="atorva-slide">
    <section class="atorva-hero fade-stagger">
      <p class="atorva-kicker">In post <strong>ACS,</strong></p>
      <div class="atorva-logo-wrap">
        <img src="{{ asset('images/atorva.png') }}" alt="Atorva Gold" class="atorva-brand-img" />
        <span class="atorva-strength">10<br />20</span>
      </div>
      <p class="atorva-composition">Atorvastatin 10/20 mg + Clopidogrel 75 mg + Aspirin 75 mg Capsules</p>
    </section>

    <div class="essential-band fade-stagger">
      <span>The Essential Choice</span>
    </div>

    <div class="purity-badge fade-stagger" aria-label="99.5 percent purity">
      <span>99.5%</span>
      <strong>PURITY</strong>
    </div>

    <section class="atorva-content">
      <div class="pellet-zone fade-stagger">
        <div class="pellet-label">PELLET-PELLET<br />FORMULATION</div>
        <svg class="capsule-svg" viewBox="0 0 420 330" role="img" aria-label="Pellet pellet formulation capsules">
          <defs>
            <linearGradient id="whiteCap" x1="0" x2="1">
              <stop offset="0%" stop-color="#ffffff" />
              <stop offset="45%" stop-color="#ece5e0" />
              <stop offset="100%" stop-color="#bfb7b3" />
            </linearGradient>
            <linearGradient id="redCap" x1="0" x2="1">
              <stop offset="0%" stop-color="#f9b2a5" />
              <stop offset="38%" stop-color="#e52616" />
              <stop offset="100%" stop-color="#ad0d08" />
            </linearGradient>
            <filter id="capShadow" x="-20%" y="-20%" width="140%" height="150%">
              <feDropShadow dx="0" dy="10" stdDeviation="8" flood-color="#7a1710" flood-opacity=".22" />
            </filter>
          </defs>

          <ellipse cx="190" cy="188" rx="145" ry="118" fill="#f6d2cb" opacity=".42" />

          <g filter="url(#capShadow)" transform="rotate(39 168 126)">
            <rect x="83" y="86" width="145" height="58" rx="29" fill="url(#whiteCap)" />
            <line x1="122" y1="90" x2="187" y2="140" stroke="#ffffff" stroke-width="7" opacity=".45" />
          </g>
          <g filter="url(#capShadow)" transform="rotate(-42 248 122)">
            <rect x="180" y="84" width="145" height="58" rx="29" fill="url(#redCap)" />
            <line x1="218" y1="88" x2="286" y2="138" stroke="#ffddd7" stroke-width="6" opacity=".45" />
          </g>

          <g class="pellets">
            <circle cx="166" cy="155" r="3" fill="#dc1d12" />
            <circle cx="185" cy="166" r="2.5" fill="#ff6b2b" />
            <circle cx="205" cy="174" r="3" fill="#e21e10" />
            <circle cx="222" cy="187" r="2.5" fill="#f6a23b" />
            <circle cx="189" cy="199" r="2" fill="#138808" />
            <circle cx="238" cy="207" r="3" fill="#dc1d12" />
            <circle cx="215" cy="225" r="2" fill="#ff6b2b" />
            <circle cx="252" cy="230" r="2.4" fill="#138808" />
            <circle cx="147" cy="184" r="2.2" fill="#f6a23b" />
            <circle cx="162" cy="212" r="2" fill="#138808" />
            <circle cx="278" cy="203" r="2" fill="#e21e10" />
            <circle cx="259" cy="174" r="2.6" fill="#f6a23b" />
            <circle cx="133" cy="220" r="2" fill="#dc1d12" />
            <circle cx="283" cy="239" r="2.2" fill="#f6a23b" />
            <circle cx="221" cy="250" r="2.4" fill="#e21e10" />
            <circle cx="192" cy="239" r="2" fill="#138808" />
            <circle cx="246" cy="154" r="2.1" fill="#dc1d12" />
            <circle cx="173" cy="235" r="2.1" fill="#ff6b2b" />
          </g>

          <path id="friendlyCurve" d="M94 264 C140 324 255 330 322 268" fill="none" />
          <text class="friendly-text">
            <textPath href="#friendlyCurve" startOffset="50%" text-anchor="middle">at a Pocket-Friendly Price</textPath>
          </text>
          <g class="gear-mark" transform="translate(305 234)">
            <circle cx="0" cy="0" r="18" fill="#c92319" opacity=".95" />
            <circle cx="0" cy="0" r="7" fill="#fff" />
            <path d="M0 -28 L4 -19 L-4 -19 Z M0 28 L4 19 L-4 19 Z M-28 0 L-19 4 L-19 -4 Z M28 0 L19 4 L19 -4 Z" fill="#c92319" />
          </g>
        </svg>
      </div>

      <div class="wave-lines fade-stagger" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
      </div>

      <aside class="feature-panel fade-stagger">
        <h2><span>Atorvastatin +</span> Clopidogrel + Aspirin</h2>
        <div class="feature-item">
          <span class="feature-icon plaque-icon"></span>
          <p>Stabilizes atherosclerotic<br />plaque post ACS</p>
        </div>
        <div class="feature-item">
          <span class="feature-icon artery-icon"></span>
          <p>Reduces arterial<br />thrombosis</p>
        </div>
      </aside>
    </section>

    <section class="atorva-bottom fade-stagger">
      <div class="also-ribbon">ALSO<br />AVAILABLE</div>
      <div class="atorva-40">
        <span>Atorva</span><strong>Gold</strong><em>40</em>
      </div>
      <div class="price-capsule">
        <strong>Rs. 12</strong>
        <span>PER CAPSULE</span>
      </div>
    </section>

    <p class="acs-note">ACS: Acute Coronary Syndrome</p>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="{{ asset('js/AtorvaGold.js') }}"></script>

</body>
</html>
