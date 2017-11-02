$(document).ready(function () {
    $('#vendorlogo').customFileInput();
   
    // modal popup open
    $('.clickopen').on('click', function (e) {
        e.preventDefault();
        $("#vendorcategory").val($(this).data('id'));
        $('#popup').modal('show');

    });

   
    
    // sign up form
    $('#signupform').on('submit', function (event) {
        event.preventDefault();
        formData = new FormData($(this)[0]);
       
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
                if (data.responseJSON.status == 1) {   
        
                    setErrorNotification(data);
                }else{
                      $('.alert-danger').hide();
                    $('.errormessage').html('');
                }
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');
                var errors = data.responseJSON.errors;
                if(errors!=''){
                $.each(errors, function (key, value) {
                    if (key == 'vendor_category' || key == 'vendor_country' || key == 'billing_country') {
                        var inputname = $("select[name=" + key + "]").parent();
                    } else {
                        var inputname = $("input[name=" + key + "]").parent();
                    }
                    inputname.addClass('has-error');
                    inputname.append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                });
            }
            }
        });

    });
    // add custom rules for credit card validating



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
});
    