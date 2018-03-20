$(document).ready(function () {


    var options = {
        url: function (phrase) {
            return "yelp/getlist?tag_list=" + phrase + "&vendor_address=" + $('#vendor_address').val();
        },
        getValue: function (element) {
            if (element.length === 0) {
                return "No results";
            } else {
                return element.name;
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return  item.name + " <br> " + item.location.display_address;
            }
        }
    };

    $("#vendor_name").easyAutocomplete(options);
    // sign up form
    $('#loginform').on('submit', function (event) {
        event.preventDefault();
        formData = $(this).serialize();

        $.ajax({
            url: "vendor/login",
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#loadingDiv').hide();
                if (data.status == 3) {
                    var decodedString = atob(data.view);
                    $('body').removeClass('modal-open pages pages-homepage').addClass('price-page').removeAttr('style').html(decodedString);
                } else {
                    $('#login').modal('hide');
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

                $('#loadingDiv').hide();
                if (data.responseJSON != '' && data.responseJSON.status == 0) {
                    setErrorNotification(data);
                } else {
                    $('.alert-danger').hide();
                    $('.errormessage').html('');
                }
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');

                if (data.responseJSON != '') {
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
      $('#yelpdatatable').DataTable({
            processing: true,
             dom: '<"top"i>rt<"bottom"flp><"clear">',
            serverSide: true,
            ordering: false,
            info: true,
            searching: false,
           pageLength: 10,
           lengthChange:false,
           fnDrawCallback:function(){
var oTable = $('#yelpdatatable').DataTable();
if(oTable.length==0){
$('#yelpdatatable_paginate').css("display", "none");
}
},
             oLanguage: { sEmptyTable: "No records found" },
            ajax: "yelp/getlist?tag_list",
             columns: [
            {
                mRender: function (data, type, row) {
                 return '<h4 class="s-title">'+row.name+'</h4><span class="s-address">'+row.location.display_address+'</span>';
                    
                },
                orderable: false,
                searchable: false,
            
            },
          {
                mRender: function (data, type, row) {
                 return '<a href="#popup" class="continue-btn call-to-action button" data-toggle="modal" >Continue</a>';
                    
                },
                orderable: false,
                searchable: false,
            
            },
             ],
        });

    $('#yelpform').on('submit', function (event) {
        event.preventDefault();
   
     $('.yelpdata').removeClass("hidden");
        
    });



});
// sign up form


function initAutocomplete() {

    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('vendor_address')),
            {types: ['geocode']});


}