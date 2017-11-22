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
});

