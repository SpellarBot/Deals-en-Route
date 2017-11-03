$(document).ready(function () {
  
    // sign up form
    $('#loginform').on('submit', function (event) {
        event.preventDefault();
        formData=$(this).serialize();
       
        $.ajax({
            url: "vendor/login",
            type: 'POST',
            data: formData,
            success: function (data) { 
             
               if(data.status==1){
                  $('#login').modal('hide'); 
                    location.reload();
               }else{  
               $('body').removeClass('modal-open pages pages-homepage').addClass('price-page').removeAttr('style').html(data);  
               }
            
            },
             beforeSend: function () {
              $('#loadingDiv').show();
            },
            complete: function () {
             $('#loadingDiv').hide();
            },
            error: function (data) {
                
                $('#loadingDiv').hide();
                 if(data.responseJSON!=''  && data.responseJSON.status==0 ){
                     setErrorNotification(data);
                }else{
                     $('.alert-danger').hide();
                    $('.errormessage').html('');
                }
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');
                
                if(data.responseJSON!=''){
                    var errors = data.responseJSON.errors;
                $.each(errors, function (key, value) {
                    var inputname = $("input[name=" + key + "]").parent();   
                    inputname.addClass('has-error');
                    inputname.append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                });
            }
            }
        });

    });
    // add custom rules for credit card validating



});
    

