/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
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
        formData.append('vendor_logo',file_data);
        console.log(formData);
        $.ajax({
            url: "register/update",
            type: 'POST',
            data: formData,
            contentType: false, 
            cache: false, 
            processData: false,
            success: function (data) {
                console.log(data);
//                return false;
                if (data.status == 0) {
                    $('.editCompanyDetails').find("input").val("");
                    $('.alert-danger').show();
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('slow');
                    }, 10000);
                    $('.errormessage').html(data.message);
                } else {
                    $('.editCompanyDetails').find("input").val("");
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
                $('.editCompanyDetails').find("input").val("");
                $('#loadingDiv').hide();
                $('.alert-danger').show();
                setTimeout(function () {
                    $('.alert-danger').fadeOut('slow');
                }, 10000);
                $('.errormessage').html(data.responseJSON.message);
            }
        });
    });
});

