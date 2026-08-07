<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zydus | Independence Day 2026 — Welcome</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
  <!-- Global stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body>

  <!-- Zydus Logo -->
  <div class="brand-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Zydus Logo" />
  </div>

  <!-- Page Content -->
  <div class="page-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

          <div class="form-card">
            <h1 class="form-title">Independence Day 2026</h1>
            <p class="form-subtitle">ZYDUS • 15<sup>TH</sup> AUGUST CELEBRATION</p>

              <form id="welcomeForm" action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data" novalidate>
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

                  <div class="mb-3">
                      <label class="form-label-custom">Photo</label>
                      <input type="file" id="photo" name="photo" class="photo-input-native" accept="image/*">
                      <input type="hidden" id="cropped_photo" name="cropped_photo">

                      <div class="photo-upload-box" id="photoUploadBox">
                          <button type="button" class="photo-upload-btn" id="photoUploadBtn">
                              <span class="photo-upload-icon" aria-hidden="true">
                                  <svg viewBox="0 0 24 24" role="img">
                                      <path d="M12 16V5m0 0 4 4m-4-4-4 4M5 19h14" />
                                  </svg>
                              </span>
                              <span class="photo-upload-text">
                                  <strong>Upload Photo</strong>
                                  <em>JPG, PNG or WEBP</em>
                              </span>
                          </button>

                          <div class="photo-preview-wrap is-hidden" id="photoPreviewWrap">
                              <img src="" alt="Cropped photo preview" class="photo-preview-img" id="photoPreviewImg">
                              <button type="button" class="photo-change-btn" id="photoChangeBtn">Change Image</button>
                          </div>
                      </div>
                      <small id="photoError" class="text-danger"></small>
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

  <div class="modal fade photo-crop-modal" id="photoCropModal" tabindex="-1" aria-labelledby="photoCropModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="photoCropModalLabel">Crop Photo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="cropper-shell">
                      <div id="photoCropper"></div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="crop-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="crop-save-btn" id="cropPhotoBtn">Crop Photo</button>
              </div>
          </div>
      </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- jQuery Validation Plugin -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
  <!-- Page Script -->
    <script src="{{ asset('js/index.js') }}"></script>

</body>
</html>
