var $table = $('#bootstrap-table, #bootstrap-table1, #bootstrap-table2');

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



// sign up form
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

var count = 1;
function nextTab(elem) {
    value = parseInt($('.stepsincrement').val()) + 1;
    if (value == 4) {
     if($( "#create-coupon" ).hasClass( "has-error" )==false){
        $('.validationcheck').val(true);
    }
    }else {
        $('.stepsincrement').val(value);
        jQuery(elem).next().find('a[data-toggle="tab"]').click();
    }
}

function prevTab(elem) {
    value = parseInt($('.stepsincrement').val()) - 1;
    $('.stepsincrement').val(value);
    jQuery(elem).prev().find('a[data-toggle="tab"]').click();

}
  