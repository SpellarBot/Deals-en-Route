$(document).ready(function () {

    $('.fileinput').fileinput()


    // modal popup open
    $('.clickopen').on('click', function (e) {
        e.preventDefault();
//        if ($(this).data('id') == 'other') {
//            $("#vendorcategory").addClass('hide');
//            $("#vendorcategory").attr('disabled', 'disabled');
//            $('input[name=vendor_category]').removeClass('hide');
//            $('input[name=vendor_category]').removeAttr('disabled');
//        } else {
        $("#vendorcategory").val($(this).data('id'));
//        }
        $('#popup').modal('show');
    });
//    $('#vendorcategory').change(function () {
//        var cat = $(this).val();
//        if (cat == 'other') {
//            $(this).addClass('hide');
//            $(this).attr('disabled', 'disabled');
//            $('input[name=vendor_category]').removeClass('hide');
//            $('input[name=vendor_category]').removeAttr('disabled');
//        }
//    });
//
//    $('input[name=vendor_category]').change(function () {
//        var cat = $(this).val();
//        if (cat == '' || cat.trim() == '') {
//            $("#vendorcategory").removeClass('hide');
//            $("#vendorcategory").removeAttr('disabled');
//            $(this).addClass('hide');
//            $(this).attr('disabled', 'disabled');
//        }
//});
    $('#check-address').on('click', function (event) {
        if ($('#check-address').is(':checked')) {
//check the name
            $("#billingdetails").slideUp();
        } else {
            $("#billingdetails").slideDown();
        }

    });
// sign up form
    $('#signupform').on('submit', function (event) {

        event.preventDefault();
        formData = new FormData($(this)[0]);
        formData.append('vendor_time_zone', (new Date()).getTimezoneOffset());
        $.ajax({
            url: $('#hidAbsUrl').val() + "/register/create",
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {

                $('#popup').modal('hide');
                $('body').removeClass('modal-open').addClass('price-page').removeAttr('style').html(data);
            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                $('#loadingDiv').hide();
                if (data.responseJSON.status == 0) {

                    setErrorNotification(data);
                } else {
                    $('.alert-danger').hide();
                    $('.errormessage').html('');
                }
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');
                var errors = data.responseJSON.errors;
                if (errors != '') {
                    $.each(errors, function (key, value) {
                        if (key == 'vendor_logo') {
                            $('.vendorlogo').append('<span class="has-error help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.

                        } else {
                            if (key == 'vendor_category' || key == 'vendor_country' || key == 'billing_country') {
                                var inputname = $("select[name=" + key + "]").parent();
                            } else {
                                var inputname = $("input[name=" + key + "]").parent();
                            }
                            inputname.addClass('has-error');
                            inputname.append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                        }
                    });
                }
            }
        });
    });
// add custom rules for credit card validating
    $('#requestCategory').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $('#hidAbsUrl').val() + "/vendor/requestCategory",
            type: 'POST',
            data: formData,
            success: function (data) {
                console.log(data);
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');

                if (data.status == 'success') {
                    $('#otherCategoryModal .close').click();
                    setDashboardNotification(data);
                    setTimeout(function () {
                        window.location.href = $('#hidAbsUrl').val() + '/index';
                    }, 3000);
                } else {
                    $('#otherCategoryModal .close').click();
                    setDashboardNotification(data);
                    setTimeout(function () {
                        window.location.href = $('#hidAbsUrl').val() + '/index';
                    }, 3000);
                }
            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');
                if (data.responseJSON != '') {
                    var errors = data.responseJSON.message;
                    $.each(errors, function (key, value) {
                        var inputname = $("input[name=" + key + "]").parent();
                        inputname.addClass('has-error');
                        inputname.append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                    });
                }
            }
        });
    });


    new Cleave('.cardNumber', {
        creditCard: true,
        onCreditCardTypeChanged: function (type) {

            document.querySelector('.type').innerHTML = '<i class="fa fa-cc-' + type + ' fa-fw fa-2x active" aria-hidden="true"></i>';
        }
    });
    new Cleave('.expiry', {
        date: true,
        datePattern: ['m', 'y']
    });
}
);

    