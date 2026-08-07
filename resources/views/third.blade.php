<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Every ACS Patient Deserves Golden Moments</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body class="bg-slide-3">

  <div class="brand-logo">
     <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" />
  </div>

  <div class="page-wrapper">
    <div class="container">
      <!-- doctor-container class add ki -->
      <div class="row content-row doctor-container">

        <!-- Left: Doctor Photo (doctor-col class add ki) -->
        <div class="col-12 col-md-6 text-center mb-4 mb-md-0 doctor-col">
          <!-- doctor-frame class add ki image size kam karne ke liye -->
          <div class="image-frame doctor-frame">
            <img src="{{ asset('images/doctor.png') }}" alt="Doctor" />
          </div>
        </div>

        <!-- Right: Reveal text -->
        <div class="col-12 col-md-6 text-block doctor-text" id="doctorTextContainer">
          <!-- Dark text split into two lines as per requirement -->
          <span class="text-line lg dark-text">Doctor,</span>
          <span class="text-line lg dark-text">it's time to relive those</span>
          <!-- Gold gradient text with Typewriter animation -->
          <span class="text-line xl gold-gradient-text typewriter">GOLDEN MOMENTS</span>
        </div>

      </div>
    </div>

    <a href="{{route('activity')}}" class="btn-next">Next</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="{{ asset('js/third.js') }}"></script>
</body>
</html>