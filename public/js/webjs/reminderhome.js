var hidAbsUrl = "";
var arrDeleteReminderId = [];


$(document).ready(function(){
    
    hidAbsUrl = $('#hidAbsUrl').val();

    /* Init DataTables */
    reminderDashboardTable = $('#reminderDashboardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: hidAbsUrl + '/getReminderDashboard',
            type: "GET",
            data: function(d) {
                d.dateRangeFilter = $('#lastDateRangeFilter').val(),
                d.startDate = $('#txtStartDate').val();
                d.endDate = $('#txtEndDate').val();
                d.isPrivate = $('#selectPcheck').is(':checked');
             
            }
        },
        columnDefs: [
            {
                render : function(data, type, row) {
                    return row.reminderDateTime;
                },
                width: "10%",
                targets : 0
            },
            {
                render : function(data, type, row) {
                    return row.purpose;
                },
                width: "10%",
                targets : 1
            },
            {
                render : function(data, type, row) {
                    return row.fullname;
                },
                width: "10%",
                targets : 2
            },
            {
                render : function(data, type, row) {
                    return row.caseno;
                },
                width: "10%",
                targets : 3
            },
            {
                render : function(data, type, row) {
                    return row.snsUserName;
                },
                width: "14%",
                targets : 4
            },
            {
                render : function(data, type, row) {
                    return row.confirmDate;
                },
                width: "10%",
                targets : 5
            },
            {
                render : function(data, type, row) {

                    var twilioStatus = row.twiliostatus;
                    var reminderId = row.recid;

                    var url = '<input type="checkbox" name="chkDeleteReminder" class="form-control deleteReminder" data-reminderId="' + reminderId + '" value="' + reminderId + '"/>&nbsp;&nbsp;';

                    if(twilioStatus == null) {
                        url += '<a class="text-danger" href="' + hidAbsUrl + '/' + reminderId + '/reminderEdit" ><i class="fa fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    }

                    return url;
                },
                width: "5%",
                targets : 6
            }
        ],
        createdRow: function(row, data, index) {
            $(row).css('background-color', data.twilioResponseColor);
        }
        
    });
    
    
    $('#reminderDashboardTable tbody').on('click', 'tr td:not(:last-child)', function () {
         var table = $('#reminderDashboardTable').DataTable();

        var data = $(this).parent('tr').find('.deleteReminder').attr('data-reminderid');
        window.location.replace(data+"/reminderEdit/view");
    } );
    $(document.body).delegate('.deleteReminder', 'click', function (e) {
        var thisObj = $(this);

        var flagChecked = thisObj.prop('checked');
        var reminderId = thisObj.val();

        if(flagChecked) {
            arrDeleteReminderId = [...arrDeleteReminderId, reminderId];
        }
        else {
            _.pull(arrDeleteReminderId, reminderId);
        }
    });

    $('#btnDeleteReminder').on('click', function() {
        if(_.isEmpty(arrDeleteReminderId)) {
            var objDataParams = {
                message: "Please select atleast one reminder to delete"
            };
            setToastNotification(objDataParams);
        }
        else {
            var urlToGetData = hidAbsUrl + '/deleteReminder';
            var objDataParams = {
                reminderIds : arrDeleteReminderId
            }

            $.ajax({
                url: urlToGetData,
                method: "GET",
                data: objDataParams,
                beforeSend: function () {
                    $.blockUI();
                },
                complete: function () {
                    $.unblockUI();
                },
                success: function (response) {

                    if(response['data'] == 'undefined' || response['flagMsg'] == 'undefined' || response['error'] == 'undefined') {
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

                    if(typeof response['message'] != 'undefined') {
                        message = response['message'];
                    }

                    if(error == "1") {
                        switch(flagMsg) {
                            default :
                                var objErrorToastNotication = {
                                    message: "Some Error Occured"
                                };
                                setToastNotification(objErrorToastNotication);
                            break;
                        }
                    }
                    else {
                        switch(flagMsg) {
                            case "EMPTY":
                                var objErrorToastNotication = {
                                    message: message
                                };
                                setToastNotification(objErrorToastNotication);
                                break;
                            case "UPDATE":
                                var objErrorToastNotication = {
                                    message: message
                                };
                                setToastNotification(objErrorToastNotication);
                                reminderDashboardTable.draw();

                            break;
                        }
                    }
                }
            });
        }
    });

    $('#btnRefreshDatbleContent').on('click', function(e) {
        e.preventDefault();
        reminderDashboardTable.draw();
    });

    $('#txtStartDate').datepicker();
    $('#txtEndDate').datepicker();

    $('#lastDateRangeFilter').on('change', function() {
        var thisValue = $(this).val();

        $('#txtStartDate').val('');
        $('#txtEndDate').val('');

        $('#divStartDate').addClass('hidden');
        $('#divEndDate').addClass('hidden');

        if(thisValue == "SD") {
            $('#divStartDate').removeClass('hidden');
            $('#divEndDate').addClass('hidden');
        }
        else if(thisValue == "CR") {
            $('#divStartDate').removeClass('hidden');
            $('#divEndDate').removeClass('hidden');
        }
    });
//refresh table when checked
    $('#btnSearchFilters').on('click', function(e) {
        e.preventDefault();
   
        reminderDashboardTable.draw();
    });

    $('#txtSearchForReminderUser').on('keypress', function(e) {
        if (e.keyCode == 13) {
            redirectToAddReminder($(this).val());
        }
    });
});

 $('#selectPcheck').on('click', function(e) {      
        reminderDashboardTable.draw();
    });

function redirectToAddReminder(strSearchUser) {

    if(!_.isEmpty(strSearchUser)) {
        var urlToRedirect = hidAbsUrl + '/addReminder/' + strSearchUser;
        window.location = urlToRedirect;
    }
    else {
        var objErrorToastNotication = {
            message: "Please enter search keyword"
        };
        setToastNotification(objErrorToastNotication);
        $('#txtSearchForReminderUser').focus();
    }
}