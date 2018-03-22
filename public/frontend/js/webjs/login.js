$(document).ready(function () {

    // vendor name  autocomplete
    var options = {
        url: function (phrase) {
            return "yelp/gettagslist?vendor_name=" + phrase + "&vendor_address=" + $('#vendor_address').val();
        },
        getValue: function (element) {
            if (element.length === 0) {
                return "No results";
            } else {
                return element.name;
            }
        },
        list: {
            onClickEvent: function () {
                $("#vendorname").val($("#vendor_name").val());
                $('#popup').modal('show');
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

});

// yelp submit form
$('#yelpform').on('submit', function (event) {
    event.preventDefault();
    $(".form-group").removeClass('has-error');
    $(".help-block").html('');
    var vendor_name = $('#vendor_name').val();
    var vendor_address = $('#vendor_address').val();
    if (vendor_address == "") {
        var inputname = $("input[name=vendor_address]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong> Please enter the location.</strong> </span>'); //showing only the first error.   
    } else if (vendor_name == "") {
        var inputname = $("input[name=vendor_name]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong> Please enter the business name</strong> </span>'); //showing only the first error.   
    } else {
        $('.yelpdata').removeClass("hidden");
        $('#yelpdatatable').DataTable({
            processing: true,
            dom: '<"top"i>rt<"bottom"flp>',
            serverSide: true,
            ordering: false,
            info: true,
            searching: false,
            destroy: true,
            pageLength: 10,
            lengthChange: false,
            oLanguage: {sEmptyTable: "No records found"},
            fnDrawCallback: function () {
                var oTable = $('#yelpdatatable').DataTable();
                var api = this.api();
 
             if (api.rows( {page:'current'}).data().length == 0) {
                  $(".dataTables_empty").append("<a href='#popup' class='addbusiness-btn call-to-action button' data-toggle='modal' >Add Your Business</a>")
                    $('#yelpdatatable_paginate').css("display", "none");
                    $('.dataTables_wrapper .top').css("display", "none");
                    $('.dataTables_wrapper .bottom').css("display", "none");
                    $('.dataTables_wrapper thead').css("display", "none");
                }else {
                   $('#yelpdatatable_paginate').css("display", "block"); 
                }
            },
            ajax: {
                type: "POST",
                url: 'yelp/getlist',
                beforeSend: function () {
                    $('#loadingDiv').show();
                },
                complete: function () {
                    $('#loadingDiv').hide();
                },
                data: function (d) {
                    d.vendor_name = $('#vendor_name').val();
                    d.vendor_address = $('#vendor_address').val();
                },

            },
            columns: [
                {
                    render: function (data, type, row) {
                        return '<h4 class="s-title">' + row.name + '</h4><span class="s-address">' + row.location.display_address + '</span>';
                    }
                },
                {
                    render: function (data, type, row) {
                        return '<a href="#popup" class="continue-btn call-to-action button" data-toggle="modal" >Continue</a>';
                    },
                    orderable: false,
                    searchable: false,
                }
            ],
        });
    }

});

function initAutocomplete() {

    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocompleteregister = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete1')),
            {types: ['geocode']});
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocompleteregister.addListener('place_changed', fillInAddress);
    // Create the autocomplete object, restrictin
    // g the search to geographical
    // location types.

    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('vendor_address')),
            {types: ['geocode']});


}

//google map  search
var placeSearch, autocomplete;
var componentForm = {

    country: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code: 'short_name',
};

function fillInAddress() {

// Get the place details from the autocomplete object.
    var place = autocompleteregister.getPlace();
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