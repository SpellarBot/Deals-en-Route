$(document).ready(function () {

    var logTable = $('#twilologs').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            data: function (d) {
                d.daterangefilter = $('#dateRangeFilter').val();
               
                d.startdate = $('#txtStartDate').val();
                d.enddate = $('#txtEndDate').val();
            }
        },
        oLanguage: {sEmptyTable: "No records found"},
        columns: [
             
             {
                mRender: function (data, type, row) {
                 hidAbsUrl = $('#hidAbsUrl').val();
                    return '<a class="reminder_search" href="'+hidAbsUrl+"/"+row.reminderid+'/reminderEdit/view" data-key=' + row.recid + '><i class="fa fa-search" aria-hidden="true"></i></a>';
                },
                className: "center",
                orderable: false,
                searchable: false
            },

            {
                mRender: function (data, type, row) {

                    return '<a class="reminder_call" href="" data-key=' + row.recid + '><i class="fa fa-phone" aria-hidden="true"></i></a>';
                },
                className: "center",
                orderable: false,
                searchable: false
            },
            {data: 'recid', name: 'recid'},
            {data: 'tonumber', name: 'tonumber'},
            {data: 'twiliostatus', name: 'twiliostatus'},
            {data: 'duration', name: 'duration'},
            {data: 'startdate', name: 'startdate'},
            {data: 'typex', name: 'typex'},
            {data: 'firstname', name: 'firstname'},
            {data: 'lastname', name: 'lastname'}

           
        ],
aaSorting: [[ 6, "desc" ]],
    });


//    logTable.on( 'order.dt search.dt', function () {
//        logTable.column(2, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//            cell.innerHTML = i+1;
//        } );
//    } ).draw();

    $('#txtStartDate').datepicker();
    $('#txtEndDate').datepicker();

    $('#dateRangeFilter').on('change', function () {
        var thisValue = $(this).val();

        $('#txtStartDate').val('');
        $('#txtEndDate').val('');

        $('#divStartDate').addClass('hidden');
        $('#divEndDate').addClass('hidden');

        if (thisValue == '3') {
            $('#divStartDate').removeClass('hidden');
            $('#divEndDate').addClass('hidden');
        } else if (thisValue == '4') {
            $('#divStartDate').removeClass('hidden');
            $('#divEndDate').removeClass('hidden');
        }
    });

    $('#btnSearchFilters').on('click', function (e) {
        e.preventDefault();
        logTable.draw();
    });

    // Delete a record
    $('#twilologs').on('click', 'a.reminder_call', function (e) {
        hidAbsUrl = $('#hidAbsUrl').val();
        e.preventDefault();
        if (confirm("Are you sure to reschedule Reminder after 2 minutes"))
        {
            var table = $('#mastertemplates').DataTable();
            var parent = $(this).attr('data-key');
            $.ajax({
                url: hidAbsUrl + "/log/addtwiliodate/" + parent,
                method: "GET",
            }).done(function (result_data) {
                var objErrorToastNotication = {
                    message: "Successfull sent call"
                };
                setToastNotification(objErrorToastNotication);
                table.row($(this).parents('tr')).remove().draw(false);

            });
            return false;
        }
    });


});



    