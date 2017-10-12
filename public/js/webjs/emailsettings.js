
// update record
$('.updatesetting').on('click', function (e) {
    e.preventDefault();

    var $token = $('input[name=_token]').val();
    $.ajax({
        url: hidAbsUrl + "/settings/updateEmailSettings",
        type: 'PATCH',
        data: $("#settingsemail-form").serialize(),
        dataType: 'json',

        success: function (data) {

            $(".help-block").html("");
            $(".help-block").parents('.form-group').removeClass('has-error');
            var objErrorToastNotication = {
                message: data.message
            };
            setToastNotification(objErrorToastNotication);
        },
        error: function (data) {
            var errors = data.responseJSON;
            $.each(errors, function (key, val) {
                $("#" + key).parents('.form-group').find('.help-block').html('<strong>' + val[0] + '</strong>');
                $("#" + key).parents('.form-group').addClass('has-error');

            });
        }
    })
return false;

});
    