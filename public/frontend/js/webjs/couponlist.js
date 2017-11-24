var $table = $('#bootstrap-table, #bootstrap-table1, #bootstrap-table2');
var map;
var mapshow;
var drawingManager;
var showFirstMap = '';
var showSecMap = '';
var selectedShape;
var marker;
var count = 1;
var polyOptions = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true,
    fillColor: '#ff0000',
    strokeColor: '#ff0000'
};
var date = new Date();
var markershow;
var showArray = [];

$(document).ready(function () {

    $('.fileinput').fileinput();
    jQuery(".prev-step").click(function (e) {

        var $active = jQuery('.wizard .nav-tabs-step li.active');
        prevTab($active);

    });

// slider
    $('#couponslider').slider({
        formatter: function (value) {
            return 'Radius miles: ' + value;
        }
    });

    window.operateEvents = {
        'click .view': function (e, value, row, index) {
            info = JSON.stringify(row);

            swal('You click view icon, row: ', info);
            console.log(info);
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
        showColumns: true,
        pagination: true,
        searchAlign: 'left',
        pageSize: 8,
        clickToSelect: false,
        pageList: [8, 10, 25, 50, 100],

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
    $(".row input[type=text]").keyup(function () {
        id = $(this).attr('id');
        value = $(this).val();
        $("." + id).text(value);
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

        }
        if (finalvalue == 0 || finalvalue != '') {
            $('#final_value').val(finalvalue);
        }
    });


    // Select your input element.
    $('#coupon_redeem_limit,#percentage_price,#value_price').keydown(function (e) {
        if (!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58)
                || e.keyCode == 8)) {
            return false;
        }
    });

});

// date picker
$(document).on("focus", ".datepicker", function () {
    var date = new Date();
    var startdate=$('#couponstartdate').val();

    if(startdate==''){
        var start=new Date(date.getTime());
         var end=date.setDate(date.getDate() + 30);
    }else{
         var start = new Date(startdate);
         var end=date.setDate(start.getDate() + 30);
    }
    $(this).datetimepicker({

        format: 'h  A, DD MMM Y',
        showClose: true,
        useCurrent:true,
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
        $("#coupon_end_date").val(date);
        //show in last tab
        $(".coupon_end_date").text(date);

    });
});


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

        if ($("#create-coupon").hasClass("has-error") == false) {
            formData.append('validationcheck', '1');
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
                window.location.href = $('#hidAbsUrl').val()+"#create";
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
                    } else if (key == 'coupon_notification_sqfeet') {
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
                setDashboardNotification(data);

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
                    } else if (key == 'coupon_notification_sqfeet') {
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
    if (href == '#create2') {
        clearFormData();
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

        zoom: 7,
        fullscreenControl: false,
        streetViewControl: false,
        mapTypeControl: false,
    });
    // add marker for map 1
    marker = new google.maps.Marker({
        position: position,
        map: map
    });

    // show map 2
    mapshow = new google.maps.Map(document.getElementById('googelgeofencingshow'), {
        zoom: 7,
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
        if (showFirstMap != '' || showSecMap != '') {
            showFirstMap.setMap(null);
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
        polygonOptions: polyOptions,
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
//        polygonArray.push(polygon);
//    });
    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {

        var radius = e.overlay;

        getSquareFeet(radius);


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

        }

    });



}

//delete polygon
function deletePolygon() {

    $('#resetfence').text('Draw Fence');
    $('#coupon_notification_sqfeet').val('');
    $('#coupon_notification_point').val('');
    showFirstMap.setMap(null);

    drawingManager.setDrawingMode(null);
    // To hide:
    drawingManager.setOptions({
        drawingControl: false
    });
    selectedShape.setMap(null);

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
    // set polygon shape for second map

    var sqfeet = google.maps.geometry.spherical.computeArea(radius.getPath()) * 10.7639;

    $('#info').html('<label> Area Sqft Covered:- </label>' + sqfeet + ' ft²');

    $('.couponsqft').text(sqfeet + ' ft²');
    $('#coupon_notification_sqfeet').val(JSON.stringify(sqfeet));
    $('#coupon_notification_point').val(JSON.stringify(showArray));
    if (showSecMap != '') {
        showSecMap.setMap(null);
    }

    setPolygonSecMapShape();
}


// set polygon shape for first map 
function setPolygonFirstMapShape() {

// show polygon


    showFirstMap = new google.maps.Polygon({
        paths: showArray,
        strokeWeight: 0,
        fillOpacity: 0.45,
        editable: true,
        fillColor: '#ff0000',
        strokeColor: '#ff0000',
        editable: false
    });

    showFirstMap.setMap(map);

}

// set polygon shape for second map 
function setPolygonSecMapShape() {
// show polygon
    showSecMap = new google.maps.Polygon({

        paths: showArray,
        strokeWeight: 0,
        fillOpacity: 0.45,
        editable: true,
        fillColor: '#ff0000',
        strokeColor: '#ff0000',
        editable: false
    });
    showSecMap.setMap(mapshow);

}
