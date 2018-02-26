$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#loadingDiv').hide().ajaxStart(function () {
        $('#loadingDiv').show();
    }).ajaxStop(function () {
        $('#loadingDiv').hide();
    });

    //modal close
    $(".modal").on("hidden.bs.modal", function () {
//        $('.form-control').val('');
        $(".form-group").removeClass('has-error');
        $(".input-group").removeClass('has-error');
        $(".help-block").html('');
        $('.alert-danger').hide();
    });


    $('#changepackage').on('click', function (e) {
        var hash = '#settings';
        $('#myModal').modal('hide');
        $('#groupTab li a[href=' + hash + ']').tab('show');
    });

});

var hexDigits = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");


//clear form data
function clearFormData() {
    $('#sendcontact').find("input[type=text]").not('input[name=_token]').val("");
    $('#create-coupon').find("input[type=text],input[type=number],input[type=hidden]").not('input[name=_token],input[name=coupon_code]').val("");
    
    $('#settings').find("input[type=text],input[type=number],input[type=password]").not('input[name=_token]').val("");
    $('.wizard-inner .nav-tabs a:first').tab('show');
    $(".wizard-inner .nav-tabs li:not(:first-child)").addClass("disabled");
    $('.fileinput').fileinput('clear');
    $(".form-group").removeClass('has-error');
    $(".help-block").html('');
    $('.stepsincrement').val(1);
    $('.validationcheck').val(0);


}

function setToastNotification(objDataParams) {

    var header = "Deals en Route";
    if (typeof objDataParams.header != 'undefined') {
        header = objDataParams.header;
    }

    var message = "Welcome!!";
    if (typeof objDataParams.message != 'undefined') {
        message = objDataParams.message;
    }

    setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success(header, message);

    }, 1000);
}

$(window).load(function () {
    $("#loadingDiv").fadeOut("slow");
});

// for jquery response json notification
function setErrorNoti(message) {

    $('.alert-danger').show();
    setTimeout(function () {
        $('.alert-danger').fadeOut('slow');
    }, 10000);
    $('.errormessage').html(message);

}

// for jquery response json notification
function setErrorNotification(data) {
    if (data.responseJSON.status == 0) {
        $('.alert-danger').show();
        setTimeout(function () {
            $('.alert-danger').fadeOut('slow');
        }, 10000);
        $('.errormessage').html(data.responseJSON.message);
    } else {
        $('.alert-success').show();
        setTimeout(function () {
            $('.alert-success').fadeOut('slow');
        }, 10000);
        $('.successmessage').html(data.responseJSON.message);
    }

}

function setFlashSuccessNotification() {

    $('.alert-success').show();
    setTimeout(function () {
        $('.alert-success').fadeOut('slow');
    }, 10000);

}
function setFlashErrorNotification() {

    $('.alert-danger').show();
    setTimeout(function () {
        $('.alert-danger').fadeOut('slow');
    }, 10000);

}

// for dashboard notiufication
function setDashboardNotification(response) {

    if (response.status == 0) {

        $('.alert-danger').show();
        setTimeout(function () {
            $('.alert-danger').fadeOut('slow');
        }, 10000);

        $('.errormessage').html(response.message);
    } else {
        clearFormData();
        $('.alert-success').show();
        setTimeout(function () {
            $('.alert-success').fadeOut('slow');
        }, 10000);
        $('.successmessage').html(response.message);
    }



}

$(document).on('click', '#addhours', function () {
    $('.hoursofoperationalert').remove();
    $('a[href=#settings]').click();
});
$(document).on('click', '#remindmelater', function () {
    $('.hoursofoperationalert').remove();
});