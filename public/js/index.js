$(document).ready(function () {
    const $photoInput = $('#photo');
    const $croppedPhoto = $('#cropped_photo');
    const $photoUploadBtn = $('#photoUploadBtn');
    const $photoChangeBtn = $('#photoChangeBtn');
    const $photoUploadBox = $('#photoUploadBtn');
    const $photoPreviewWrap = $('#photoPreviewWrap');
    const $photoPreviewImg = $('#photoPreviewImg');
    const $photoCropper = $('#photoCropper');
    const cropModalEl = document.getElementById('photoCropModal');
    const cropModal = cropModalEl ? new bootstrap.Modal(cropModalEl) : null;
    let croppieInstance = null;

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

    $('#cropPhotoBtn').on('click', function () {
        if (!croppieInstance) {
            return;
        }

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
            $photoPreviewImg.attr('src', croppedImage);
            $photoUploadBox.addClass('is-hidden');
            $photoPreviewWrap.removeClass('is-hidden');
            $('#photoError').text('');
            $photoInput.valid();
            cropModal.hide();
        });
    });

    if (cropModalEl) {
        cropModalEl.addEventListener('hidden.bs.modal', resetCropper);
    }

    // Only numbers allowed
    $('#bo_code, #doctor_code').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $.validator.addMethod('croppedPhotoRequired', function () {
        return $croppedPhoto.val().length > 0;
    }, 'Please crop your photo');

    $('#welcomeForm').validate({

        rules: {
            bo_code: {
                required: true,
                digits: true,
                minlength: 2,
                maxlength: 20
            },

            doctor_code: {
                required: true,
                digits: true,
                minlength: 2,
                maxlength: 20
            },

            name: {
                required: true,
                minlength: 2
            },

            photo: {
                required: true,
                extension: "jpg|jpeg|png|webp",
                croppedPhotoRequired: true
            }
        },

        messages: {
            bo_code: {
                required: "Please enter BO Code",
                digits: "Only numbers are allowed",
                minlength: "BO Code is too short"
            },

            doctor_code: {
                required: "Please enter Doctor Code",
                digits: "Only numbers are allowed",
                minlength: "Doctor Code is too short"
            },

            name: {
                required: "Please enter your name",
                minlength: "Name is too short"
            },

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
                return;
            }

            $(element).css('border-color', '#d9534f');
        },

        unhighlight: function (element) {
            if (element.id === 'photo') {
                $('#photoUploadBtn').css('border-color', 'rgba(212,175,55,.72)');
                return;
            }

            $(element).css('border-color', '#D4AF37');
        },

        submitHandler: function (form) {

            const userData = {
                bo_code: $('#bo_code').val(),
                doctor_code: $('#doctor_code').val(),
                name: $('#name').val()
            };

            localStorage.setItem('zydusUser', JSON.stringify(userData));

            form.submit();
        }

    });

});
