$(document).ready(function () {
    // Only numbers allowed
    $('#bo_code, #doctor_code').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

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
            }
        },
        errorElement: 'span',
        errorClass: 'field-error',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).css('border-color', '#d9534f');
        },
        unhighlight: function (element) {
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
