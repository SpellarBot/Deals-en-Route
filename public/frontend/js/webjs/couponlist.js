var $table = $('#bootstrap-table, #bootstrap-table1, #bootstrap-table2');
var map;
var mapshow;
var drawingManager;
var showFirstMap = '';
var showSecMap = '';
var selectedShape;
var marker;
var count = 1;
var totalSqFeetDrawn;
var additionalCost;
var polyOptions_invalid = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true,
    fillColor: '#ff0000',
    strokeColor: '#ff0000'
};
var polyOptions_valid = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true,
    fillColor: '#008000',
    strokeColor: '#008000'
};
var date = new Date();
var markershow;
var showArray = [];
var totalprice;
var b;

$(document).ready(function () {
    if (localStorage.getItem("NewCoupon"))
    {
        $('.alert-success').show();
        $('.successmessage').html(localStorage.getItem("NewCoupon"));
        setTimeout(function () {
            $('.alert-success').fadeOut('slow');
        }, 10000);
        localStorage.clear();
    }

    $('.fileinput').fileinput();
    jQuery(".prev-step").click(function (e) {

        var $active = jQuery('.wizard .nav-tabs-step li.active');
        prevTab($active);

    });

// slider
    $('#couponslider').slider({

        formatter: function (value) {
            $('.total_miles').text(value);
            return 'Radius miles: ' + value;
        }
    });

    window.operateEvents = {
        'click .view': function (e, value, row, index) {
            info = JSON.stringify(row);

            swal('You click view icon, row: ', info);

        },
        'click .edit': function (e, value, row, index) {
            $('#loadingDiv').hide();
            window.location.href = $('#hidAbsUrl').val() + '/coupon/edit/' + btoa(row._id);

        },
        'click .remove': function (e, value, row, index) {

            info = JSON.stringify(row);
            conf = confirm("Are you sure you want to delete this coupon?");
            if (conf === true) {
                $('#loadingDiv').show();

                $.ajax({
                    url: $('#hidAbsUrl').val() + '/coupon/' + row._id,
                    type: 'DELETE',

                    success: function (data) {
                        $('#loadingDiv').hide();
                        setDashboardNotification(data);
                        $table.bootstrapTable('remove', {
                            field: '_id',
                            values: [row._id]
                        });

                    },
                    beforeSend: function () {
                        $('#loadingDiv').show();
                    },
                    complete: function () {
                        $('#loadingDiv').hide();
                    },
                    error: function (data) {
                        $('#loadingDiv').hide();
                    }


                });


            }

        }
    };

    $table.bootstrapTable({
        toolbar: ".toolbar",
        clickToSelect: true,
        showRefresh: true,
        search: true,
        showToggle: true,
        showColumns: false,
        pagination: true,
        searchAlign: 'left',
        pageSize: 8,
        clickToSelect: false,
        pageList: [8, 10, 25, 50, 100],
        formatNoMatches: function () {
            return 'Please add some deals to start seeing the data.';
        },
        formatShowingRows: function (pageFrom, pageTo, totalRows) {
            //do nothing here, we don't want to show the text "showing x of y from..."
        },
        formatRecordsPerPage: function (pageNumber) {
            return pageNumber + " rows visible";
        },
        icons: {
            refresh: 'fa fa-refresh',
            toggle: 'fa fa-th-list',
            columns: 'fa fa-columns',
            detailOpen: 'fa fa-plus-circle',
            detailClose: 'fa fa-close'
        }
    });

    //activate the tooltips after the data table is initialized
    //$('[rel="tooltip"]').tooltip();

    $(window).resize(function () {

        $('#loadingDiv').hide();
        $table.bootstrapTable('resetView');
    });

    //select row input
    $(".row input[type=text],.row input[type=number] ").keyup(function () {
        
        id = $(this).attr('id');
          $("." + id).html('');
        value = $(this).val();
        if (id == 'original_price') {
            $("." + id).text("$" + value);

        } else {

            $("." + id).text(value);
        }
    });

    // change percentage value  
    $(document).on("change keyup blur", '#original_price, #percentage_price, #value_price', function (e) {
        //original price
        if ($(this).attr('id') == 'value_price') {
            $('#percentage_price').val('');
        }
        if ($(this).attr('id') == 'percentage_price') {
            $('#value_price').val('');
        }
        var orig = $('#original_price').val();
        var dperc = $('#percentage_price').val();
        var dval = $('#value_price').val();

        if (dperc != '' && orig != '') {

            var disc = ((dperc) / 100) * ((orig));
            var finalvalue = (orig) - (disc);
        } else if (dval != '' && orig != '') {

            var finalvalue = (orig) - (dval);

        } else {
            finalvalue = 0;
        }
        if (finalvalue == 0 || finalvalue != '') {
            $('#final_value').val((finalvalue).toFixed(2));
            $('.new-price').text("$" + $('#final_value').val());
        }
    });


    // Select your input element.
    $('#coupon_redeem_limit,#percentage_price,#value_price,#original_price').keydown(function (e) {
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str) || e.which == 8 || e.which == 190) {
            return true;
        }

        e.preventDefault();
        return false;

    });
    // Select your input element.
    $('#coupon_code').keydown(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str) || e.which == 8) {
            return true;
        }

        e.preventDefault();
        return false;
    });

});

// date picker
$(document).on("focus", ".datepicker", function () {
    var date = new Date();
    var currentdate = $("#couponenddate").val();
    var startdate = $('#couponstartdate').val();
    var start = new Date(date.getTime());
    if (startdate == '') {

        var end = date.setDate(date.getDate() + 30);
    } else {
        var startdate = new Date(startdate);
        var end = date.setDate(startdate.getDate() + 30);
    }
    $(this).datetimepicker({

        format: 'M/D/YY - h:00 A',
        date: currentdate,
        showClose: true,
        useCurrent: true,
        minDate: start,
        maxDate: end,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove',
            todayBtn: true,
            autoclose: true,

        }
    }).on('dp.change', function (e) {
        var date = $('.datepicker').data('date');
        var enddate = new Date(date);
        var currentdate = new Date();
     
        $('#gethours').text(enddate.getHours());
        $('#getminutes').text(enddate.getMinutes());
        var end = datediff(currentdate, enddate);
        $('#getdays').text(end);
        $("#coupon_end_date").val(date);
        //show in last tab
        $(".coupon_end_date").text(date);

    });
});

function datediff(startDay, endDay) {
    from = moment(startDay, 'YYYY-MM-DD');

    to = moment(endDay, 'YYYY-MM-DD');

    /* using diff */
    duration = to.diff(from, 'days');
    return duration
}

//create coupon
$('#create2').on("click", ".next-step", function (event) {
    $('#create-coupon').trigger('submit');
});

//update coupon
$('#update').on("click", ".next-step", function (event) {
    $('#update-coupon').trigger('submit');
});


// update coupon submit
$(document).on("submit", "#update-coupon", function (event) {
    event.preventDefault();
    var id = $('.coupon_id').val();
    formData = new FormData($(this)[0]);
    formData.append('coupon_id', id);
    
    //if value =4 i.e last step then
    value = parseInt($('.stepsincrement').val()) + 1;

    if (value == 4) {

        if ($("#update-coupon").hasClass("has-error") == false) {
            formData.append('validationcheck', '1');
             formData.append('totalprice', totalprice);
          
        }
    }

    $.ajax({
        url: $('#hidAbsUrl').val() + "/coupon/update",
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status == 1) {
                $('#loadingDiv').hide();
                setDashboardNotification(data);
                window.location = $('#hidAbsUrl').val() + "#create";

            } else {

                var $active = jQuery('.wizard .nav-tabs-step li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
                $(".form-group").removeClass('has-error');
                $(".help-block").html('');

            }
        },
        beforeSend: function () {
            $('#loadingDiv').show();
        },
        complete: function () {
            $('#loadingDiv').hide();
        },
        error: function (data) {
            $(".form-group").removeClass('has-error');
            $(".checkbox").removeClass('has-error');
            $(".help-block").html('');
            // setErrorNoti('Please resolve the error');
            if (data.responseJSON.errors != '') {
                $.each(data.responseJSON.errors, function (key, value) {
                    if (key == 'coupon_logo') {
                        $('.couponlogo').append('<span  class="has-error help-block"> <strong style="color:#a94442">' + value[0] + '</strong> </span>'); //showing only the first error.
                    } else if (key == 'coupon_notification_point') {
                        setDashboardNotification({message: value[0], status: 0}); //showing only the first error.
                    } else {
                        $("input[name=" + key + "]").parent().addClass('has-error');
                        $("input[name=" + key + "]").parent().append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                    }
                });
            }
        }


    });

});

// create coupon submit
$(document).on("submit", "#create-coupon", function (event) {

    event.preventDefault();

    formData = new FormData($(this)[0]);
    //if value =4 i.e last step then
    value = parseInt($('.stepsincrement').val()) + 1;

    if (value == 4) {

        if ($("#create-coupon").hasClass("has-error") == false) {
            formData.append('validationcheck', '1');
            formData.append('totalprice', totalprice);
            formData.append('total_geofence_buy', additionalCost.total_geo_fence_buy);
            formData.append('total_geolocation_buy', additionalCost.total_geo_location_buy);
            formData.append('totalgeofenceadditionalleft', additionalCost.totalgeofenceadditionalleft);
            formData.append('totalgeolocationadditionalleft', additionalCost.totalgeolocationadditionalleft);
        }
    }
    $.ajax({
        url: $('#hidAbsUrl').val() + "/coupon/store",
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status == 1) {
                $('#loadingDiv').hide();
                localStorage.setItem("NewCoupon", data.message)
                location.reload(true);

            } else {

                var $active = jQuery('.wizard .nav-tabs-step li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
                $(".form-group").removeClass('has-error');
                $(".help-block").html('');

            }
        },
        beforeSend: function () {
            $('#loadingDiv').show();
        },
        complete: function () {
            $('#loadingDiv').hide();
        },
        error: function (data) {
            $(".form-group").removeClass('has-error');
            $(".checkbox").removeClass('has-error');
            $(".help-block").html('');

            if (data.responseJSON.errors != '') {
                $.each(data.responseJSON.errors, function (key, value) {
                    if (key == 'coupon_logo') {
                        $('.couponlogo').append('<span  class="has-error help-block"> <strong style="color:#a94442">' + value[0] + '</strong> </span>'); //showing only the first error.
                    } else if (key == 'coupon_notification_point' || key == 'coupon_notification_sqfeet') {
                        setDashboardNotification({message: value[0], status: 0}); //showing only the first error.
                    } else {
                        $("input[name=" + key + "]").parent().addClass('has-error');
                        $("input[name=" + key + "]").parent().append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
                    }
                });
            }
        }


    });
});


function operateFormatter(value, row, index) {
    return [
        '<div class="table-icons">',
        '<a rel="tooltip" title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit"  href="javascript:void(0)">',
        '<i class="fa fa-pencil"></i>',
        '</a>',
        '<a rel="tooltip" title="Remove" class="btn btn-simple btn-danger btn-icon table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-close"></i>',
        '</a>',
        '</div>',
    ].join('');
}

//next tab
function nextTab(elem) {

    value = parseInt($('.stepsincrement').val()) + 1;
    if (value != 4) {
        $('.stepsincrement').val(value);
        jQuery(elem).next().find('a[data-toggle="tab"]').click();
    }

}

// resize google map
$(document).on("shown.bs.tab", "a[data-toggle='tab']", function (event) {

    var href = $(this).attr('href');
    if (href == '#create2' || href == '#settings' || href == '#contact') {
        clearFormData();
        deletePolygon();
        $('#resetfence').text('Draw Fence');
        $('#info').html('');
    }
    var value = $(this).find('.round-tab').text();
    if (value == 1 || value == 2 || value == 3) {
        $('.stepsincrement').val($.trim(value));

    }

    // set center positionv of shape
    google.maps.Polygon.prototype.my_getBounds = function () {
        var bounds = new google.maps.LatLngBounds()
        this.getPath().forEach(function (element, index) {
            bounds.extend(element)
        })
        return bounds
    }
    google.maps.event.trigger(map, 'resize');
    google.maps.event.trigger(mapshow, 'resize');
    map.setZoom(19);
    mapshow.setZoom(19);
    if (showFirstMap != '') {
        map.setCenter(showFirstMap.my_getBounds().getCenter());

    } else {
        map.setCenter(marker.getPosition());
    }
    if (showSecMap != '') {
        mapshow.setCenter(showSecMap.my_getBounds().getCenter());
    }
});

//previous tab
function prevTab(elem) {

    value = parseInt($('.stepsincrement').val()) - 1;
    $('.stepsincrement').val(value);

    jQuery(elem).prev().find('a[data-toggle="tab"]').click();

}

// This example requires the Drawing library. Include the libraries=drawing
//initialize map
function Maps() {

    position = {lat: parseFloat($('.vendor_lat').val()), lng: parseFloat($('.vendor_long').val())};
    // show map 1
    map = new google.maps.Map(document.getElementById('googlegeofencing'), {

        zoom: 19,
        fullscreenControl: false,
        streetViewControl: false,
        mapTypeControl: false,
    });


    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });


    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }



        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }




            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });


    // add marker for map 1
    marker = new google.maps.Marker({
        position: position,
        map: map
    });

    // show map 2
    mapshow = new google.maps.Map(document.getElementById('googelgeofencingshow'), {
        zoom: 19,
        center: position,

    });
    // add marker for map 2
    markershow = new google.maps.Marker({
        position: position,
        map: mapshow
    });
    if ($('#coupon_notification_point').val() != '') {
        showArray = JSON.parse($('#coupon_notification_point').val());
        setPolygonFirstMapShape();
        setPolygonSecMapShape();
    }



//    var centerControlDiv = document.createElement('div');
//    var centerControl = new CenterControl(centerControlDiv, map);
//    centerControlDiv.index = 1;
//    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

}


// clear selection
function clearSelection() {
    if (selectedShape) {
        selectedShape.setEditable(false);
        selectedShape = null;
    }
}

// set selection
function setSelection(shape) {
    clearSelection();
    selectedShape = shape;
    shape.setEditable(true);

}

// onclick event
function onClickEvent() {

    if ($('#resetfence').text() == 'Draw Fence') {
        if (showFirstMap != '') {
            showFirstMap.setMap(null);
        }
        if (showSecMap != '') {
            showSecMap.setMap(null);
        }
        createPolygon();
    } else {
        deletePolygon();

    }
}

//create polygon
function createPolygon() {
    $('#resetfence').text('Reset Fence');

    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControlOptions: {
            drawingModes: [
                google.maps.drawing.OverlayType.POLYGON
            ]
        },
        markerOptions: {
            draggable: true
        },

        polylineOptions: {
            editable: true
        },

        map: map
    });

    drawingManager.setOptions({
        drawingControl: false
    });
//        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
//        document.getElementById('info').innerHTML += "polygon points:" + "<br>";
//        for (var i = 0; i < polygon.getPath().getLength(); i++) {
//            document.getElementById('info').innerHTML += polygon.getPath().getAt(i).toUrlValue(6) + "<br>";
//        }
//    });
    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {

        var radius = e.overlay;


        if (e.type != google.maps.drawing.OverlayType.MARKER) {

            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setDrawingMode(null);
            // To hide:
            drawingManager.setOptions({
                drawingControl: false
            });

            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            var newShape = e.overlay;
            newShape.type = e.type;
            changeShape(newShape);
            setSelection(newShape);
            getSquareFeet(radius);

        }

    });



}

//delete polygon
function deletePolygon() {

    $('#resetfence').text('Draw Fence');
    $('#coupon_notification_sqfeet').val('');
    $('#coupon_notification_point').val('');
    if (showFirstMap != '') {
        showFirstMap.setMap(null);
    }
    if (drawingManager) {
        drawingManager.setDrawingMode(null);
        // To hide:
        drawingManager.setOptions({
            drawingControl: false
        });
        selectedShape.setMap(null);
    }

}

//change latitude longitude after polygon gets changed
function changeShape(newShape) {

    newShape.getPaths().forEach(function (path, index) {

        google.maps.event.addListener(path, 'insert_at', function () {
            getSquareFeet(newShape);
        });

        google.maps.event.addListener(path, 'remove_at', function () {
            getSquareFeet(newShape);
        });

        google.maps.event.addListener(path, 'set_at', function () {
            getSquareFeet(newShape);
        });

    });
}
//SELECT * FROM user_detail WHERE MBRContains(ST_GeomFromText('Polygon(( -98.07697478272888 30.123832577126326, -98.07697478272888 30.535734310413392, -97.48302581787107 30.535734310413392, -97.48302581787107 30.123832577126326, -98.07697478272888 30.123832577126326))'), POINT(latitude,longitude))
//display sq feet
function getSquareFeet(radius) {

    var polygonBounds = radius.getPath();
    if (showArray != '') {
        showArray = [];
    }

    for (var a = 0; a < polygonBounds.length; a++)
    {
        showArray.push({"lat": polygonBounds.getAt(a).lat(), "lng": polygonBounds.getAt(a).lng()});
    }

    showArray.push({"lat": polygonBounds.getAt(0).lat(), "lng": polygonBounds.getAt(0).lng()});
    // set polygon shape for second map

    var sqfeet = google.maps.geometry.spherical.computeArea(radius.getPath()) * 10.76;


    var sqnum = Number((sqfeet).toFixed(2)).toLocaleString('en');
    var sqnumfixed = Number((sqfeet).toFixed(2));
    $('#info').html('<label> Area Sqft Covered : </label>  ' + sqnum + ' ft²');

    $('.couponsqft').text(sqnum + ' ft²');
    $('#coupon_notification_sqfeet').val(JSON.stringify(sqnumfixed));
    $('#coupon_notification_point').val(JSON.stringify(showArray));
    var geofencing = $('.geofencingshow').text();
    if (showSecMap != '') {
        showSecMap.setMap(null);
    }
    b = parseInt(geofencing).toFixed(2);

    totalSqFeetDrawn = sqnumfixed
    if ((totalSqFeetDrawn) < (b)) {
        var total_left = b - sqfeet;
        $('.total_left_used').html("<label> Remaining Left : </label> " + Number((total_left).toFixed(2)).toLocaleString('en') + ' ft²');
        selectedShape.setOptions({'fillColor': '#008000', strokeColor: '#008000', strokeWeight: 0});
         setPolygonSecMapShapeOnCreate(1);
    } else {
        var total_left = sqfeet - b;
        $('.total_left_used').html("<label> Additional Fence Used : </label> " + Number((total_left).toFixed(2)).toLocaleString('en') + ' ft²');

        selectedShape.setOptions({'fillColor': '#ff0000', strokeColor: '#ff0000', strokeWeight: 0});
         setPolygonSecMapShapeOnCreate(0);
    }

  
}


// set polygon shape for first map 
function setPolygonFirstMapShape() {

// show polygon
    var options = $.extend(polyOptions_valid, {'paths': showArray}, {editable: false});
    showFirstMap = new google.maps.Polygon((options));
    showFirstMap.setMap(map);


}

// set polygon shape for second map 
function setPolygonSecMapShapeOnCreate(flag) {
    if(flag==1){
// show polygon   
    var options = $.extend(polyOptions_valid, {'paths': showArray}, {editable: false});
    showSecMap = new google.maps.Polygon((options));
    showSecMap.setMap(mapshow);
    }else{
        // show polygon   
    var options = $.extend(polyOptions_invalid, {'paths': showArray}, {editable: false});
    showSecMap = new google.maps.Polygon((options));
    showSecMap.setMap(mapshow);
    }

}

// set polygon shape for second map 
function setPolygonSecMapShape() {
// show polygon   
    var options = $.extend(polyOptions_valid, {'paths': showArray}, {editable: false});
    showSecMap = new google.maps.Polygon((options));
    showSecMap.setMap(mapshow);

}


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

function initCallback() {
    initAutocomplete();
    Maps();
}

function getCouponcode() {
    $.ajax({
        url: $('#hidAbsUrl').val() + "/coupon/generateCouponCode",
        type: 'GET',
        success: function (data) {
            
            $('input[name=coupon_code]').val(data.message);
            $('.coupon_code').text(data.message);
            
        },
        beforeSend: function () {
            $('#loadingDiv').show();
        },
        complete: function () {
            $('#loadingDiv').hide();
        },
        error: function (data) {
            $('#loadingDiv').hide();
            $('#coupon_code').removeAttr('readonly');
        }
    });
}
//$(document).on('click', '.createcoupon', function (e) {
//    $.ajax({
//        url: $('#hidAbsUrl').val() + "/coupon/generateCouponCode",
//        type: 'GET',
//        success: function (data) {
//            $('.coupon_code_textbox').val(data.message);
//            $('.coupon_code').text(data.message);
//        },
//        beforeSend: function () {
//            $('#loadingDiv').show();
//        },
//        complete: function () {
//            $('#loadingDiv').hide();
//        },
//        error: function (data) {
//            $('#loadingDiv').hide();
//            $('#coupon_code').removeAttr('readonly');
//        }
//    });
//});
$(document).on('click', '.getextracost', function (e) {

    e.preventDefault();
     var coupon_id= ($('.coupon_id').val()); 
    if(coupon_id==""){
    var geofencing = $('.geofencing').text();
    b = parseInt(geofencing).toFixed(2);
    $.ajax({
        url: $('#hidAbsUrl').val() + "/coupon/additonalcost",
        type: 'POST',
        data: {'totaldrawn': totalSqFeetDrawn, 'totalcovered': b, 'totalgeomilesselected': $('.total_miles').text()},
        success: function (data) {
            additionalCost = data;
            totalprice = data.total_rs;
            $('.totalextra').text(data.total_rs + "$");

        }, error: function (data) {

            $('.totalextra').text(data);

        }

    });
    }
});

$(document).on("submit", ".additional_miles_coupon", function (event) {
    event.preventDefault();
    var miles = parseInt($('#extra_miles').val());
    var additional = parseInt($('#couponslider').data('sliderMax'));
    var total = miles + additional;
    $('#couponslider').slider({
        max: total,
        formatter: function (total) {
            $('.total_miles').text(total);
            return 'Radius miles: ' + total;
        }
    });
    $('#couponslider').slider('setValue', total, true);
    $('#couponslider').slider('disable');
    $('#extra_miles').val('');
    $('#buyextramiles').modal('hide');

});

$(document).on("submit", ".additional_fencing_coupon", function (event) {
    event.preventDefault();
    var fence = parseInt($('#extra_fence').val());
    var additional =parseInt(b);
     b = fence + additional;
    $('.geofencingshow').text(b);
    $('.total_geofencing_covered').html("<label>Total Geofencing : </label> "+ Number((b).toFixed(2)).toLocaleString('en') + ' ft²');
    if ((totalSqFeetDrawn) < (b)) {
        var total_left = b - totalSqFeetDrawn;
        $('.total_left_used').html("<label> Remaining Left : </label>" + Number((total_left).toFixed(2)).toLocaleString('en') + ' ft²');
        selectedShape.setOptions({'fillColor': '#008000', strokeColor: '#008000', strokeWeight: 0});
    } else {
        var total_left = totalSqFeetDrawn - b;
        $('.total_left_used').html("<label> Additional Fence Used : </label>" + Number((total_left).toFixed(2)).toLocaleString('en') + ' ft²');

        selectedShape.setOptions({'fillColor': '#ff0000', strokeColor: '#ff0000', strokeWeight: 0});
    }
    $('#extra_fence').val('');
    $('#buygeofencearea').modal('hide');

});