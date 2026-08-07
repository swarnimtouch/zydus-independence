$(document).ready(function () {

    $('#welcomeForm').validate({
        rules: {
            name: { required: true, minlength: 2 },
            city: { required: true, minlength: 2 },
            speciality: { required: true, minlength: 2 }
        },
        messages: {
            name: { required: 'Please enter your name', minlength: 'Name is too short' },
            city: { required: 'Please enter your city', minlength: 'City is too short' },
            speciality: { required: 'Please enter your speciality', minlength: 'Speciality is too short' }
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
                name: $('#name').val(),
                city: $('#city').val(),
                speciality: $('#speciality').val()
            };

            localStorage.setItem('zydusUser', JSON.stringify(userData));

            // Laravel controller ko submit karega
            form.submit();
        }

    });

});