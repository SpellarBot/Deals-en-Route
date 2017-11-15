var $table = $('#bootstrap-table, #bootstrap-table1, #bootstrap-table2');
var map;
var drawingManager;
var selectedShape;
var marker;
var count = 1;



$().ready(function () {
    jQuery(".prev-step").click(function (e) {

        var $active = jQuery('.wizard .nav-tabs-step li.active');
        prevTab($active);

    });

    window.operateEvents = {
        'click .view': function (e, value, row, index) {
            info = JSON.stringify(row);

            swal('You click view icon, row: ', info);
            console.log(info);
        },
        'click .edit': function (e, value, row, index) {
            info = JSON.stringify(row);

            swal('You click edit icon, row: ', info);
            console.log(info);
        },
        'click .remove': function (e, value, row, index) {

            info = JSON.stringify(row);
            conf = confirm("Do you ready want to delete this row?");
            if (conf === true) {
                $('#loadingDiv').show();
                axios.delete($('#hidAbsUrl').val() + '/coupon/' + row._id)
                        .then(response => {
                            $('#loadingDiv').hide();

                            setDashboardNotification(response);
                            $table.bootstrapTable('remove', {
                                field: '_id',
                                values: [row._id]
                            });
                        })
                        .catch(error => {
                            $('#loadingDiv').hide();
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

    // Select your input element.

    $('#coupon_radius ,#coupon_redeem_limit').keydown(function (e) {
        if (!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58)
                || e.keyCode == 8)) {
            return false;
        }
    });


});

// date picker
$('.datepicker').datetimepicker({
    format: 'h  A, DD MMM Y',

    showClose: true,
    useCurrent: true,
    minDate: new Date(),
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
    $(".coupon_end_date").text(date);
})



// create coupon form
$('.next-step').on('click', function (event) {
    $('#create-coupon').trigger('submit');
});

$('#create-coupon').on('submit', function (event) {
    event.preventDefault();
    formData = new FormData($(this)[0]);

    $.ajax({
        url: $('#hidAbsUrl').val() + "/coupon/store",
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
            var $active = jQuery('.wizard .nav-tabs-step li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
            $(".form-group").removeClass('has-error');
            $(".help-block").html('');
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
                    if (key == 'vendor_logo') {
                        $('.vendorlogo').append('<span class="has-error help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.
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
    if (value == 4) {
        if ($("#create-coupon").hasClass("has-error") == false) {
            $('.validationcheck').val(true);
        }
    } else {
        $('.stepsincrement').val(value);
        jQuery(elem).next().find('a[data-toggle="tab"]').click();
    }

}

// resize google map
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    google.maps.event.trigger(map, 'resize');
    map.setCenter(marker.getPosition());
});

//previous tab
function prevTab(elem) {
    value = parseInt($('.stepsincrement').val()) - 1;
    $('.stepsincrement').val(value);
    jQuery(elem).prev().find('a[data-toggle="tab"]').click();

}


var polyOptions = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true,
    fillColor: '#1E90FF',
    strokeColor: '#1E90FF'
};

// This example requires the Drawing library. Include the libraries=drawing
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">
//initialize map
function Maps() {

    map = new google.maps.Map(document.getElementById('googlegeofencing'), {
        center: {lat: -25.363, lng: 131.044},
        zoom: 7,
        fullscreenControl: false,
        streetViewControl: false,
        mapTypeControl: false,
    });
    // add marker
    marker = new google.maps.Marker({
        position: {lat: -25.363, lng: 131.044},
        map: map
    });
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map);
    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
   
}

// add div
function CenterControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Draw Fence';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.id = 'resetfence';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Draw Fence';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to Chicago.
    controlUI.addEventListener('click', function () {
        onClickEvent();
    });

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
        createPolygon();
    } else {
        deletePolygon();

    }
}

//create polygon
function createPolygon(){
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
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
            var radius = e.overlay;
            $('#info').html(google.maps.geometry.spherical.computeArea(radius.getPath()));
            document.getElementById('info').innerHTML += "polygon points:" + "<br>";
            for (var i = 0; i < radius.getPath().getLength(); i++) {

                document.getElementById('info').innerHTML += radius.getPath().getAt(i).toUrlValue(6) + "<br>";
            }

            if (e.type != google.maps.drawing.OverlayType.MARKER) {

                // Switch back to non-drawing mode after drawing a shape.
                drawingManager.setDrawingMode(null);
                // To hide:
                drawingManager.setOptions({
                    drawingControl: false
                });

                // Create the DIV to hold the control and call the CenterControl()
                // constructor passing in this DIV.

                // Add an event listener that selects the newly-drawn shape when the user
                // mouses down on it.
                var newShape = e.overlay;
                newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function () {

                    setSelection(newShape);
                });
                setSelection(newShape);
            }


        });
    
}

//delete polygon
function deletePolygon(){
    
    $('#resetfence').text('Draw Fence');
    drawingManager.setDrawingMode(null);
    // To hide:
    drawingManager.setOptions({
        drawingControl: false
    });
    selectedShape.setMap(null);
}

  