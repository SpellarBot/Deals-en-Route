var hidAbsUrl = "";
var csrfToken = "";
$(document).ready(function () {

    hidAbsUrl = $('#hidAbsUrl').val();

    csrfToken = $('#csrfToken').val();

    var allColorPickerEdit = $('.colorStatusChange');

    $.each(allColorPickerEdit, function (index, element) {
        var thisElement = $(element);

        var parentSpan = thisElement.parent().parent().find('.parentColorStatusChange');

        var colorCodeInRGB = parentSpan.css('background-color');

        var colorToHex = rgb2hex(colorCodeInRGB);

        var colorId = parentSpan.attr('data-colorId');

        thisElement.colorpicker({
            color: colorToHex
        }).on('changeColor', function (ev) {

            var newColor = ev.color.toHex();

            parentSpan.css('background-color', newColor);

        }).on('hidePicker', function (hidPicker) {
            var thisObj = $(this);
            var parentSpan = thisElement.parent().parent().find('.parentColorStatusChange');

            var colorCodeInRGB = parentSpan.css('background-color');
            var colorToHex = rgb2hex(colorCodeInRGB);

            var colorId = parentSpan.attr('data-colorId');

            var dataToSend = {
                colorCode: colorToHex,
                colorId: colorId
            }

            $.ajax({
                url: hidAbsUrl + '/settings/updateLogColors',
                method: "POST",
                data: dataToSend,
                beforeSend: function () {
                    $.blockUI();
                },
                complete: function () {
                    $.unblockUI();
                },
                success: function (response) {
                    if (response['data'] == 'undefined' || response['flagMsg'] == 'undefined' || response['error'] == 'undefined') {
                        var objErrorToastNotication = {
                            message: "Some Error Occured"
                        };
                        setToastNotification(objErrorToastNotication);
                        return false;
                    }

                    var error = response['error'];
                    var data = response['data'];
                    var flagMsg = response['flagMsg'];
                    var message = "";
                    if (typeof response['message'] != 'undefined') {
                        message = response['message'];
                    }

                    if (error == "1") {
                        switch (flagMsg) {
                            default :
                                var objErrorToastNotication = {
                                    message: "Some Error Occured"
                                };
                                setToastNotification(objErrorToastNotication);
                                break;
                        }
                    } else {
                        switch (flagMsg) {
                            case "UPDATE":
                                var objToastNotication = {
                                    message: message
                                };
                                setToastNotification(objToastNotication);
                                break;
                        }
                    }
                }
            });
        });
    });


    /**
     * START operation for updating timezone
     */
    $('#btnUpdateTimeZone').on('click', function () {
        var lstTimeZoneDropDown = $('#lstTimeZone').val();

        var dataToSend = {
            lstTimeZoneDropDown: lstTimeZoneDropDown
        }

        $.ajax({
            url: hidAbsUrl + '/settings/updateTimeZone',
            method: "POST",
            data: dataToSend,
            beforeSend: function () {
                $.blockUI();
            },
            complete: function () {
                $.unblockUI();
            },
            success: function (response) {
                if (response['data'] == 'undefined' || response['flagMsg'] == 'undefined' || response['error'] == 'undefined') {
                    var objErrorToastNotication = {
                        message: "Some Error Occured"
                    };
                    setToastNotification(objErrorToastNotication);
                    return false;
                }

                var error = response['error'];
                var data = response['data'];
                var flagMsg = response['flagMsg'];
                var message = "";
                if (typeof response['message'] != 'undefined') {
                    message = response['message'];
                }

                if (error == "1") {
                    switch (flagMsg) {
                        default :
                            var objErrorToastNotication = {
                                message: "Some Error Occured"
                            };
                            setToastNotification(objErrorToastNotication);
                            break;
                    }
                } else {
                    switch (flagMsg) {
                        case "UPDATE":
                            var objToastNotication = {
                                message: message
                            };
                            setToastNotification(objToastNotication);
                            break;
                    }
                }
            }
        });
    });
    /**
     * END operation for updating timezone
     */


    /**
     * START operations for updating recall settings
     */
    $('#chkRecallEnable').on('change', function () {
        var objRecallCheckbox = $(this);

        var chkRecallCheckboxChecked = objRecallCheckbox.prop('checked');

        if (chkRecallCheckboxChecked) {
            $('#divRecallOptions').removeClass('hidden');
        } else {
            $('#divRecallOptions').addClass('hidden');
        }
    });

    $('#btnUpdateRecallSettings').on('click', function () {
        var recallEnableDisable = $('#chkRecallEnable').prop('checked');
        var lstRecallHowManyTimes = $('#lstRecallHowManyTimes').val();
        var lstTimingInterval = $('#lstTimingInterval').val();

        var dataToSend = {};

        if (recallEnableDisable) {
            dataToSend.recallEnable = "1";
            dataToSend.howManyTimes = lstRecallHowManyTimes;
            dataToSend.timingInterval = lstTimingInterval;
        } else {
            dataToSend.recallEnable = "0";
            dataToSend.howManyTimes = "0";
            dataToSend.timingInterval = "0";
        }

        $.ajax({
            url: hidAbsUrl + '/settings/updateRecallSettings',
            method: "POST",
            data: dataToSend,
            beforeSend: function () {
                $.blockUI();
            },
            complete: function () {
                $.unblockUI();
            },
            success: function (response) {
                if (response['data'] == 'undefined' || response['flagMsg'] == 'undefined' || response['error'] == 'undefined') {
                    var objErrorToastNotication = {
                        message: "Some Error Occured"
                    };
                    setToastNotification(objErrorToastNotication);
                    return false;
                }

                var error = response['error'];
                var data = response['data'];
                var flagMsg = response['flagMsg'];
                var message = "";
                if (typeof response['message'] != 'undefined') {
                    message = response['message'];
                }

                if (error == "1") {
                    switch (flagMsg) {
                        default :
                            var objErrorToastNotication = {
                                message: "Some Error Occured"
                            };
                            setToastNotification(objErrorToastNotication);
                            break;
                    }
                } else {
                    switch (flagMsg) {
                        case "UPDATE":
                            var objToastNotication = {
                                message: message
                            };
                            setToastNotification(objToastNotication);
                            break;
                    }
                }
            }
        });

    });
    /**
     * END operations for updating recall settings
     */




    /**
     * START Email signature and company logo update
     */

    $('#flCompanyLogo').on('change', function () {
        readURL(this);
    });

    var emailSignatireAndCompanyLogoUploadOptions = {
        target: '#emailsignuploadresponase', // target element(s) to be updated with server response 
        beforeSubmit: showRequest, // pre-submit callback 
        success: showResponse, // post-submit callback 
        type: 'post'        // 'get' or 'post', override for form's 'method' attribute 

                // other available options: 
                //url:       url         // override for form's 'action' attribute 
                //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
                //clearForm: true        // clear all form fields after successful submit 
                //resetForm: true        // reset the form after successful submit 

                // $.ajax options can be used here too, for example: 
                //timeout:   3000 
    };

    // bind to the form's submit event 
    $('#frmUploadCompanyLogoAndPic').submit(function () {
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(emailSignatireAndCompanyLogoUploadOptions);

        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false;
    });

    /**
     * END Email signature and company logo update
     */
    // date picker for from date
 
       var FromEndDate = new Date();

      $('#input-group-fromdate,#input-group-todate').datepicker({
        todayBtn: "linked",
        endDate: FromEndDate,
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        dateFormat: 'yy-mm-dd',
        autoclose: true,     
       
    });
    
    
    
    
});



// pre-submit callback 
function showRequest(formData, jqForm, options) {
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData);

    $.blockUI();
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 

    //alert('About to submit: \n\n' + queryString); 

    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true;
}

// post-submit callback 
function showResponse(response, statusText, xhr, $form) {
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 

    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 

    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 

    //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + '\n\nThe output div should have already been updated with the responseText.'); 


    if (response['data'] == 'undefined' || response['flagMsg'] == 'undefined' || response['error'] == 'undefined') {
        var objErrorToastNotication = {
            message: "Some Error Occured"
        };
        setToastNotification(objErrorToastNotication);
        return false;
    }

    var error = response['error'];
    var data = response['data'];
    var flagMsg = response['flagMsg'];
    var message = "";
    if (typeof response['message'] != 'undefined') {
        message = response['message'];
    }

    if (error == "1") {
        switch (flagMsg) {
            default :
                var objErrorToastNotication = {
                    message: "Some Error Occured"
                };
                setToastNotification(objErrorToastNotication);
                break;
        }
    } else {
        switch (flagMsg) {
            case "UPDATE":
                var objToastNotication = {
                    message: message
                };
                setToastNotification(objToastNotication);
                break;
        }
    }
    $.unblockUI();


}



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#companyLogoPreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


//disable/enable csv records
$('#btnUpdateCsvSettings').on('click', function (e) {
   var val=$('#chkCsvEnable').prop('checked');
    if (val == true) {
        vl = 1;
    } else {
        vl = 0;
    }
    hidAbsUrl = $('#hidAbsUrl').val();
    e.preventDefault();
    $.ajax({
        url: hidAbsUrl + '/settings/updateCsvSettings',
        method: "PUT",
        data: {flagcsv: vl},
    }).done(function (result_data) {
        var objErrorToastNotication = {
            message: result_data.message
        };
        setToastNotification(objErrorToastNotication);
    });
    return false;

});


//add csv file upload for prmotional message
$('form#importpromotional').submit(function (e) {

    hidAbsUrl = $('#hidAbsUrl').val();
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: hidAbsUrl + "/settings/addPromotionalMessage",
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
          beforeSend: function () {
                $.blockUI();
            },
            complete: function () {
                $.unblockUI();
            },
        success: function (data) {
        
            $(".help-block").html("");
            $(".help-block").parents('.form-group').removeClass('has-error');
            if (data.error == 1) {
                $("#imagecsv").html('<strong>' + data.errormessage + '</strong>');
                $("#imgInp").parents('.form-group').addClass('has-error');
            } else if (data.success == 1) {
               $("#importpromotional")[0].reset();
                var objErrorToastNotication = {
                    message: data.message
                };
                setToastNotification(objErrorToastNotication);
            }
        },
    });
    return false;

});



//export report
$('form#settingsreport-form').submit(function (e) {
    hidAbsUrl = $('#hidAbsUrl').val();
    e.preventDefault();
   
    $.ajax({
        url: hidAbsUrl + "/settings/exportReport",
        type: 'POST',
        data: $("#settingsreport-form").serialize(),
         dataType: 'JSON',
       beforeSend: function () {
                $.blockUI();
            },
       complete: function () {
                $.unblockUI();
            },
        success: function (data) {
      
            $(".help-block").html("");
            $(".help-block").parents('.form-group').removeClass('has-error');
           
              if(data.error==1){
            var errors = data.message;
      
            $.each(errors, function (key, val) {     
                $("#" + key).parents('.form-group').find('.help-block').html('<strong>' + val[0] + '</strong>');
                $("#" + key).parents('.form-group').addClass('has-error');
            });
            } else {
             window.location.href = data.url;          
              //  $("#settingsreport-form")[0].reset();
            }
        },
    });
    return false;

});
