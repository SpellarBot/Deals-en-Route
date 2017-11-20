$(document).ready(function () {

    $('.fileinput').fileinput()


    // modal popup open
    $('.clickopen').on('click', function (e) {
        e.preventDefault();
        $("#vendorcategory").val($(this).data('id'));
        $('#popup').modal('show');

    });

      $('#check-address').on('click', function (event) {
        if($('#check-address').is(':checked')){
           //check the name
             $("#billingdetails").slideUp();
        } else{
            $("#billingdetails").slideDown();
        }

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
                if (data.responseJSON.status == 0) {
                    setErrorNotification(data);
                } else {
                    $('.alert-danger').hide();
                    $('.errormessage').html('');
                }
                $(".form-group").removeClass('has-error');
                $(".input-group").removeClass('has-error');
                $(".help-block").html('');
                var errors = data.responseJSON.errors;
                if (errors != '') {
                    $.each(errors, function (key, value) {
                        if (key == 'vendor_logo') {
                            $('.vendorlogo').append('<span class="has-error help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.

                        } else {
                            if (key == 'vendor_category' || key == 'vendor_country' || key == 'billing_country') {
                                var inputname = $("select[name=" + key + "]").parent();
                            } else {
                                var inputname = $("input[name=" + key + "]").parent();
                            }
                            inputname.addClass('has-error');
                            inputname.append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                        }
                    });
                }
            }
        });

    });
    // add custom rules for credit card validating



    new Cleave('.cardNumber', {
        creditCard: true,
        onCreditCardTypeChanged: function (type) {

            document.querySelector('.type').innerHTML = '<i class="fa fa-cc-' + type.trim() + ' fa-fw fa-2x active" aria-hidden="true"></i>';
        }
    });


    new Cleave('.expiry', {
        date: true,
        datePattern: ['m', 'y']
    });


});


//google map  search
var placeSearch, autocomplete;
var componentForm = {

    country: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code: 'short_name',
};
// auto complete of google search
function initAutocomplete() {

    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete1')),
            {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {

    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.


    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];

            document.getElementById(addressType).value = val;
        }
    }

}

    