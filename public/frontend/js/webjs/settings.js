/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    if (localStorage.getItem("Status"))
    {
        $('.alert-success').show();
        $('.successmessage').html(localStorage.getItem("Status"));
        setTimeout(function () {
            $('.alert-success').fadeOut('slow');
        }, 10000);
        localStorage.clear();
    }
    $('.editCreditCard').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/editCreditCard",
            type: 'POST',
            data: formData,
            success: function (data) {
                console.log(data);
                if (data.status == 0) {
                    $('.editCreditCard').find("input").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.editCreditCard').find("input").val("");
                    $('.alert-success').show();
                    setTimeout(function () {
                        $('.alert-success').fadeOut('slow');
                    }, 10000);
                    $('.successmessage').html(data.message);
                }

            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                console.log(data)
                $('.editCreditCard').find("input").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });
    new Cleave('.cardNumber', {
        creditCard: true,
        onCreditCardTypeChanged: function (type) {

            document.querySelector('.type').innerHTML = '<i class="fa fa-cc-' + type.trim() + ' fa-fw fa-2x active" aria-hidden="true"></i>';
        }
    });
    $('.editCompanyDetails').submit(function (e) {
        e.preventDefault();
        var file_data = $('#file').prop('files')[0];
        var formData = new FormData(this);
        formData.append('vendor_logo', file_data);
        console.log(formData);
        $.ajax({
            url: "register/update",
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == 0) {
                    $('.editCreditCard').find("input").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.editCreditCard').find("input").val("");
                    $('.alert-success').show();
                    setTimeout(function () {
                        $('.alert-success').fadeOut('slow');
                    }, 10000);
                    $('.successmessage').html(data.message);
                }

            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                console.log(data)
                $('.editCreditCard').find("input").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });

    // update password
    $('#updatePassword').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/updatePassword",
            type: 'POST',
            data: formData,
            success: function (data) {
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');

                if (data.status == 'success') {

                    setDashboardNotification(data);
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
    $('#hoursOfOperation').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/hoursOfOperation",
            type: 'POST',
            data: formData,
            success: function (data) {
                console.log(data);
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');

                if (data.status == 'success') {
                    setDashboardNotification(data);
                } else {
                    setDashboardNotification(data);
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

    $('.additional_miles').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/purchaseMiles",
            type: 'POST',
            data: formData,
            success: function (data) {

//                return false;
                if (data.status == 0) {
                    $('.additional_miles').find("select").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.additional_miles').find("select").val("");
                    localStorage.setItem("Status", data.message)
                    location.reload(true);

                }

            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                console.log(data);
//                return false;
                $('.additional_miles').find("select").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });
    $('.geo_fencing').submit(function (e) {
        
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/purchaseGeoFence",
            type: 'POST',
            data: formData,
            success: function (data) {
                console.log(data);
                if (data.status == 0) {
                    $('.geo_fencing').find("select").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.geo_fencing').find("select").val("");
                    localStorage.setItem("Status", data.message)
                    location.reload(true);

                }

            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                console.log(data);
                $('.geo_fencing').find("select").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });
    $('.additional_deals').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "vendor/purchaseDeals",
            type: 'POST',
            data: formData,
            success: function (data) {

                if (data.status == 0) {
                    $('.additional_deals').find("select").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.additional_deals').find("select").val("");
                    localStorage.setItem("Status", data.message)
                    location.reload(true);
                }

            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                console.log(data)
                $('.additional_deals').find("select").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });

    //Initializes the time picker
    $('#fromtimepicker1').mdtimepicker();
    $('#totimepicker1').mdtimepicker();
    $('#fromtimepicker2').mdtimepicker();
    $('#totimepicker2').mdtimepicker();
    $('#fromtimepicker3').mdtimepicker();
    $('#totimepicker3').mdtimepicker();
    $('#fromtimepicker4').mdtimepicker();
    $('#totimepicker4').mdtimepicker();
    $('#fromtimepicker5').mdtimepicker();
    $('#totimepicker5').mdtimepicker();
    $('#fromtimepicker6').mdtimepicker();
    $('#totimepicker6').mdtimepicker();
    $('#fromtimepicker7').mdtimepicker();
    $('#totimepicker7').mdtimepicker();
});

