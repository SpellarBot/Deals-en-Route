$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#loadingDiv').hide().ajaxStart(function() {
        $('#loadingDiv').show();
    }).ajaxStop(function() {
        $('#loadingDiv').hide();
    });

 //modal close
    $(".modal").on("hidden.bs.modal", function () {
        var form = $('.form').attr('id');
        $("'"+form+"'")[0].reset();
        $(".form-group").removeClass('has-error');
        $(".input-group").removeClass('has-error');
        $(".help-block").html('');
        $('.alert-danger').hide();
    });
    
  
});

var hexDigits = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 



function setToastNotification(objDataParams) {

    var header = "Deals en Route";
    if(typeof objDataParams.header != 'undefined') {
        header = objDataParams.header;
    }

    var message = "Welcome!!";
    if(typeof objDataParams.message != 'undefined') {
        message = objDataParams.message;
    }

    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success(header, message);

    }, 1000);
}

$(window).load(function() {
    $("#loadingDiv").fadeOut("slow");
});

function setErrorNotification(data){
    
        $('.alert-danger').show();
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
            },10000);
       $('.errormessage').html(data.responseJSON.errormessage);
    
}

function setFlashSuccessNotification(){
    
        $('.alert-success').show();
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
            },10000);

}
function setFlashErrorNotification(){
    
        $('.alert-danger').show();
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
            },10000);

}

