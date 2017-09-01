jQuery(function ($) {
    $(function () {
        $("#dateTimePicker").shieldDatePicker();

        $('#confirmPass').on('keyup', function () {
            if ($('#confirmPass').val() == $('#pass').val()) {
                $('#passwordMatch').html('Passwords match!').css('color', 'green');
            } else {
                $('#passwordMatch').html('Passwords do not match!').css('color', 'red');
            }
        });
    });
});