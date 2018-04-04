//google map  search
var placeSearch, autocomplete;

var componentForm = {

    country: 'short_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code: 'short_name',
};
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
            maxNumberOfElements: 5,
            onClickEvent: function () {
                var value = $("#vendor_name").getSelectedItemData();
                showData(value);
            },

            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 100,
                callback: function () {
                }
            },
            hideAnimation: {
                type: "slide", //normal|slide|fade
                time: 100,
                callback: function () {
                }
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                  var myObj, i, displaylocation = "";
                        var myObj = item.location;

                        for (i in myObj.display_address) {
                            displaylocation += myObj.display_address[i] + ", ";
                        }
                        var location = displaylocation.slice(0, -2);
                var image = (item.image_url) ? item.image_url : $('#hidAbsUrl').val() + "/public/frontend/img/yelpother.png";
                return  "<img width='50' height='50' src=" + image + "> <div class='eac-details'>" + item.name + " <br> " + location + "</div>";
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
    $('.help-block').remove();
    var vendor_name = $('#vendor_name').val();
    var vendor_address = $('#vendor_address').val();
    var flag = 1;

    if (vendor_address == "") {
        var inputname = $("#yelpform input[name=vendor_address]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong> Please enter the location.</strong> </span>'); //showing only the first error.    
        flag = 0;
    }
    if (vendor_address != "" && $('#callbackstatus').val() == 0)
    {
        var inputname = $("#yelpform input[name=vendor_address]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong>Sorry, we do not recognize the location you have entered</strong> </span>'); //showing only the first error.
        flag = 0;
    }
    if (vendor_name == "") {
        var inputname = $("#yelpform input[name=vendor_name]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong> Please enter the business name</strong> </span>'); //showing only the first error.   
        flag = 0;
    }
    if (flag == 0) {
        return false;
    } else {
        $('.yelpdata').removeClass("hidden");
        $('#yelpdatatable').DataTable({
            processing: false,
         //   serverSide: true,
            dom: '<"top"i>rt<"bottom"flp>',
            ordering: false,
            info: true,
            searching: false,
            destroy: true,
            pageLength: 25,
            lengthChange: false,

            oLanguage: {sEmptyTable: "No Results Found!", sInfo: "<div style='display: inline-block;float: left;margin-top: 13px;'> Showing  _TOTAL_ results for <b>" + $("#yelpform input[name=vendor_name]").val() + "</b> near <b>" + $("#yelpform input[name=vendor_address]").val() + "</b></div>\n\
    <div class='test123' style='display: inline-block;float: right;margin-top: -11px;'><a href='javascript:void(0)' class='addbusiness-btn call-to-action button autocompleteNoData' >Add Your Business</a></div>"},
            fnDrawCallback: function () {
                var oTable = $('#yelpdatatable').DataTable();
                var api = this.api();
                var oSettings = this.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                if (iTotalRecords == 0) {

                    $(".dataTables_empty").append('<a href="javascript:void(0)" class="addbusiness-btn call-to-action button autocompleteNoData" >Add Your Business</a>');
                    $('.dataTables_wrapper .top').css("display", "none");
                    $('.dataTables_wrapper .bottom').css("display", "none");
                    $('.dataTables_wrapper thead').css("display", "none");
                    $('#yelpdatatable_paginate').css("display", "none");
                    $('#yelpdatatable_info').css("display", "none");

                } else {
                    $('.dataTables_wrapper .top').css("display", "block");
                    $('.dataTables_wrapper .bottom').css("display", "table");
                    $('.dataTables_wrapper thead').css("display", "block");
                    $('#yelpdatatable_paginate').css("display", "block");
                    $('#yelpdatatable_info').css("display", "block");
                    $('#yelpdatatable_info').css("width", "100%");
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
                        var myObj, i, displaylocation = "";
                        var myObj = row.location;

                        for (i in myObj.display_address) {
                            displaylocation += myObj.display_address[i] + ", ";
                        }
                        var location = displaylocation.slice(0, -2);

                        var image = (row.image_url) ? row.image_url : $('#hidAbsUrl').val() + "/public/frontend/img/yelpother.png";
                        return '<img width="55" height="55" src=' + image + '><div class="search-details"><h4 class="s-title">' + row.name + '</h4><span class="s-address">' + location + '</span></div>';
                    }
                },
                {
                    render: function (data, type, row) {
                        var myJSON = encodeURIComponent(JSON.stringify(row));
                        // var temp =row;

                        return '<a href="javascript:void(0)" class="continue-btn call-to-action button clickfunction">\n\
                                <input type="hidden" value=' + myJSON + '>\n\
                                Continue\n\
                                </a>';
                    },
                    orderable: false,
                    searchable: false,
                }
            ],
        });
    }

});
// show register form on click of no data
$(document).on('click', '.autocompleteNoData', function (e) {
    e.preventDefault();
    document.getElementById('vendorname').value = $("#vendor_name").val();
    document.getElementById('autocomplete1').value = $("#vendor_address").val();
    $('#popup').modal('show');


});
$('#popup').on('shown.bs.modal', function (e) {
    e.preventDefault();
    $('body').removeClass('modal-open').addClass('modal-open');


});
$('#yelpdatatable').on('click', 'a.clickfunction', function (e) {
    e.preventDefault();
    var inputvalue = $(this).find('input[type=hidden]').val();
    var value = JSON.parse(decodeURIComponent(inputvalue));
    showData(value);
});

function showData(value) {

    if (value.image_url != '') {
        // $('.vendorlogo').append('<div class="fileinput input-group fileinput-exists " data-provides="fileinput"><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src='+value.image_url+'></div><div class="form-control" data-trigger="fileinput"><span class="fileinput-filename">test</span></div><span class="input-group-addon btn btn-default btn-file"><span class="fileinput-exists">Change</span><input value="" name="" type="hidden"> <input type="file" id="vendorlogo" name="vendor_logo"></span></div>');

        //$('.vendorlogo .fileinput-preview').find('img').attr('src',value.image_url);
    }
    if (value.name != '') {
        $("#vendorname").val(value.name);
    }
    if (value.location.country != '') {
        $("#country").val(value.location.country);
    }
    if (value.location.city != '') {
        $("#locality").val(value.location.city);
    }
    if (value.location.state != '') {
        $("#administrative_area_level_1").val(value.location.state);
    }
    if (value.location.zip_code != '') {
        $("#postal_code").val(value.location.zip_code);
    }
    if (value.location.display_address != '') {
        $("#autocomplete1").val(value.location.display_address);
    }
    $('#popup').modal('show');
}
function initAutocomplete() {

    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('vendor_address')),
            );



    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocompleteregister = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete1')),
            {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocompleteregister.addListener('place_changed', fillInAddress);
    autocomplete.addListener('place_changed', fillInAddressOnClick);
    var displaySuggestions = function (predictions, status) {
        if (status != google.maps.places.PlacesServiceStatus.OK) {
            $('.pac-container').append('<div class="pac-item customsearch"><span class="pac-icon pac-icon-marker"></span><span class="pac-item-query"><span class="pac-matched">Current Location</span></span></div>');
            return;
        }

    };
    var service = new google.maps.places.AutocompleteService();
    service.getQueryPredictions({input: document.getElementById('vendor_address')}, displaySuggestions);



}

function fillInAddress() {

    $('#callbackstatus').val(1);
// Get the place details from the autocomplete object.
    var place = autocompleteregister.getPlace();

    for (var component in componentForm) {

        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }
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

function fillInAddressOnClick() {
    $('#callbackstatus').val(1);

// Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    for (var component in componentForm) {
        document.getElementById('vendorname').value = '';
        document.getElementById('autocomplete1').value = '';
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.

    document.getElementById('vendorname').value = $("#vendor_name").val();
    document.getElementById('autocomplete1').value = $("#vendor_address").val();
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }

}
$(document).on('change', '#vendor_address', function (e) {
    e.preventDefault();
    $('#callbackstatus').val(0);
    $(".form-group").removeClass('has-error');
    $(".help-block").html('');


});

$(document).on('change', '#vendorcategory', function (e) {
    var selected = $(this).find(":selected").val();

    if (selected == 0) {
        $("#category_name").css("display", "block");
    } else {
        $("#category_name").css("display", "none");
    }

});

$(document.body).on('mousedown', '.pac-container .customsearch', function (e) {
    try {
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function (position) {
                $('#callbackstatus').val(1);
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
                $.ajax({
                    url: $('#hidAbsUrl').val() + "/register/getaddress",
                    type: 'POST',
                    data: {lat: position.coords.latitude, lng: position.coords.longitude},
                    success: function (data) {
                        $('#vendor_address').val(data);
                        console.log(data);
                    },
                    beforeSend: function () {
                        $('#loadingDiv').show();
                    },
                    complete: function () {
                        $('#loadingDiv').hide();
                    },
                    error: function (data) {
                        $('#vendor_address').val("");
                    }
                });

            });

        } else {
            console.log("test3");
            var inputname = $("input[name=vendor_address]").parent();
            inputname.addClass('has-error');
            inputname.append('<span class="help-block"> <strong>Geolocation is not supported by this browser.</strong> </span>'); //showing only the first error.

        }
    } catch (err) {
        var inputname = $("input[name=vendor_address]").parent();
        inputname.addClass('has-error');
        inputname.append('<span class="help-block"> <strong>' + err.message + '</strong> </span>'); //showing only the first error.

    }
});