$(document).ready(function () {
  
    // sign up form
    $('#forgetform').on('submit', function (event) {
        event.preventDefault();
        formData=$(this).serialize();
       
        $.ajax({
            url: "user/forgetpassword",
            type: 'POST',
            data: formData,
            success: function (data) { 
               location.reload();
             
            },
             beforeSend: function () {
              $('#loadingDiv').show();
            },
            complete: function () {
             $('#loadingDiv').hide();
            },
            error: function (data) {
                $(".form-group").removeClass('has-error');
                $(".help-block").html('');
                $('#loadingDiv').hide();
           
                if(data.responseJSON.status=='error'){
                    $(".form-group").addClass('has-error');
                    $(".form-group").append('<span class="help-block"> <strong>' +data.responseJSON.message+ '</strong> </span>'); //showing only the first error.
            
            }
            }
        });

    });
    // add custom rules for credit card validating



});
    

