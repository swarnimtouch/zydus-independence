$(document).ready(function () {
    const $photoInput = $('#photo');
    const $croppedPhoto = $('#cropped_photo');
    const $photoUploadBtn = $('#photoUploadBtn');
    const $photoChangeBtn = $('#photoChangeBtn');
    const $photoUploadBox = $('#photoUploadBtn');
    const $photoPreviewWrap = $('#photoPreviewWrap');
    const $photoPreviewImg = $('#photoPreviewImg');
    const $photoCropper = $('#photoCropper');
    const $certificatePhotoForm = $('#certificatePhotoForm');
    const $cropPhotoBtn = $('#cropPhotoBtn');
    const cropModalEl = document.getElementById('photoCropModal');
    const cropModal = cropModalEl ? new bootstrap.Modal(cropModalEl) : null;
    let croppieInstance = null;
    let isSubmitting = false;

    function getCropperSize() {
        if (window.matchMedia('(max-width: 767px)').matches) {
            return {
                viewport: 230,
                boundary: 280
            };
        }

        return {
            viewport: 300,
            boundary: 360
        };
    }

    function resetCropper() {
        if (croppieInstance) {
            croppieInstance.destroy();
            croppieInstance = null;
            $photoCropper.empty();
        }
    }

    function openFilePicker() {
        $photoInput.trigger('click');
    }

    function showCropper(imageUrl) {
        if (!cropModal) {
            return;
        }

        cropModal.show();

        setTimeout(function () {
            const cropperSize = getCropperSize();
            resetCropper();

            croppieInstance = new Croppie($photoCropper[0], {
                viewport: {
                    width: cropperSize.viewport,
                    height: cropperSize.viewport,
                    type: 'circle'
                },
                boundary: {
                    width: cropperSize.boundary,
                    height: cropperSize.boundary
                },
                enableExif: true,
                enableOrientation: true
            });

            croppieInstance.bind({
                url: imageUrl
            });
        }, 220);
    }

    $photoUploadBtn.on('click', openFilePicker);
    $photoChangeBtn.on('click', openFilePicker);

    $photoInput.on('change', function () {
        const file = this.files && this.files[0];

        if (!file) {
            return;
        }

        if (!file.type.match(/^image\/(jpeg|png|webp)$/)) {
            $('#photoError').text('Only JPG, PNG and WEBP images are allowed');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            $('#photoError').text('');
            showCropper(event.target.result);
        };

        reader.readAsDataURL(file);
    });

    $cropPhotoBtn.on('click', function () {
        if (!croppieInstance || isSubmitting) {
            return;
        }

        isSubmitting = true;
        $cropPhotoBtn.prop('disabled', true).text('Processing...');

        croppieInstance.result({
            type: 'base64',
            size: {
                width: 600,
                height: 600
            },
            format: 'png',
            circle: true
        }).then(function (croppedImage) {
            $croppedPhoto.val(croppedImage);
            $('#photoError').text('');
            $photoInput.valid();

            if ($certificatePhotoForm.valid()) {
                $certificatePhotoForm[0].requestSubmit();
                return;
            }

            isSubmitting = false;
            $cropPhotoBtn.prop('disabled', false).text('Crop & Next');
        }).catch(function () {
            isSubmitting = false;
            $cropPhotoBtn.prop('disabled', false).text('Crop & Next');
            $('#photoError').text('Please crop your photo again.');
        });
    });

    if (cropModalEl) {
        cropModalEl.addEventListener('hidden.bs.modal', resetCropper);
    }

    $.validator.addMethod('croppedPhotoRequired', function () {
        return $croppedPhoto.val().length > 0;
    }, 'Please crop your photo');

    $('#certificatePhotoForm').validate({
        rules: {
            photo: {
                required: true,
                extension: "jpg|jpeg|png|webp",
                croppedPhotoRequired: true
            }
        },
        messages: {
            photo: {
                required: "Please select a photo",
                extension: "Only JPG, JPEG, PNG and WEBP images are allowed",
                croppedPhotoRequired: "Please crop your photo"
            }
        },
        errorElement: 'span',
        errorClass: 'field-error',
        errorPlacement: function (error, element) {
            if (element.attr('id') === 'photo') {
                error.insertAfter('#photoUploadBox');
                return;
            }

            error.insertAfter(element);
        },
        highlight: function (element) {
            if (element.id === 'photo') {
                $('#photoUploadBtn').css('border-color', '#d9534f');
            }
        },
        unhighlight: function (element) {
            if (element.id === 'photo') {
                $('#photoUploadBtn').css('border-color', 'rgba(212,175,55,.72)');
            }
        }
    });
});
