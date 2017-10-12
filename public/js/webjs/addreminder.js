var hidAbsUrl = "";

var searchTable = "";
var selectedUsersTable = "";

var arrCurrentSearchResult = [];
var arrUserSelected = [];
var arrUsersAdded = [];
var arrSelectedUsersUnqId = [];

$(document).ready(function(){

    hidAbsUrl = $('#hidAbsUrl').val();

    var txtSearchForCustomers = $('#txtSearchForCustomers').val();
    if(!_.isEmpty(txtSearchForCustomers)) {
        searchCustomersFromDatabase();        
    }

    getSelectedUserDetailForUpdateReminder();


    $('#input-group-datepicker').datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
         todayHighlight: true,
        autoclose: true
    });

    $('.clockpicker').clockpicker();

    /* Init DataTables */
    selectedUsersTable = $('#selectedUsersTable').DataTable({
        "lengthMenu": [ 5 ]
    });

    $('#selectedUsersTable').on( 'page.dt', function () {
        addEditable();
    });

    $('#selectedUsersTable').on( 'draw.dt', function () {
        addEditable();
    });

    addEditable();

    /* Init DataTables */
    searchTable = $('#searchTable').DataTable({
        "lengthMenu": [ 5 ]
    });

    $('#btnSearchForCustomers').on('click', function() {
        searchCustomersFromDatabase();
    });


    $('#txtSearchForCustomers').on('keypress', function(e) {
        if (e.keyCode == 13) {
            searchCustomersFromDatabase();
        }
    });

    $(document.body).delegate('.addThisContactInList', 'click', function (e) {
        var objThis = $(this);
        
        var flagChecked = objThis.prop('checked');

        var id = objThis.attr('data-cardCode');
        var contactType = objThis.attr('data-contactType');
        
        var flagDuplicate = false;
        var flagNeedToUpdateRecord = true;
        var userToPerformAction = {};

        $.each(arrCurrentSearchResult, function(index, eachSearchedUser){
            if(eachSearchedUser.cardCode == id && eachSearchedUser.contactType == contactType) {
                if(flagChecked) {

                    var selectedUserUnqId = id + '--' + contactType;

                    if($.inArray(selectedUserUnqId, arrSelectedUsersUnqId) != -1) {
                        alert("Duplicate record found");
                        objThis.prop('checked', false);
                    }
                    else {
                        arrUserSelected.push(eachSearchedUser);
                    }
                }
                else {
                    var selectionRemoveIndex = -1;
                    $.each(arrUserSelected, function(indexSelectionRemove, objElementSelectionRemove){
                        if(objElementSelectionRemove.cardCode == id && objElementSelectionRemove.contactType == contactType) {
                            selectionRemoveIndex = indexSelectionRemove;
                        }
                    });

                    if(selectionRemoveIndex >= 0) {
                        arrUserSelected.splice(selectionRemoveIndex, 1);
                    }
                }
            }
        });

        debugAll(".addThisContactInList");
    });


    $('#btnAddSelect').on('click', function(){
        if(arrUserSelected.length > 0) {

            generateSelectedTableData(arrUserSelected, true);
            clearAllSelectedSearchedUsers();

        }
        else {
            alert("Please select any contact from above table.");
        }

        debugAll('#btnAddSelect');
    });


    $(document.body).delegate('.btnRemoveUserFromSelectedContact', 'click', function() {
        var thisObj = $(this);

        var id = thisObj.attr('data-cardCode');
        var contactType = thisObj.attr('data-contactType');
        
        if(arrUsersAdded.length > 0) {
            var flagWillDeleteAddedUser = false;
            var addedUserUnqId = "";
            var indexToDelete = -1;
            $.each(arrUsersAdded, function(addedUserIndex, addedUserContact) {
                if(addedUserContact.cardCode == id && addedUserContact.contactType == contactType) {
                    indexToDelete = addedUserIndex;
                    flagWillDeleteAddedUser = true;
                    var loopId = addedUserContact.cardCode;
                    var loopContactType = addedUserContact.contactType;
                    addedUserUnqId = loopId + '--' + loopContactType;
                }
            });

            if(flagWillDeleteAddedUser) {
                arrUsersAdded.splice(indexToDelete, 1);
                var unqPos = arrSelectedUsersUnqId.indexOf(addedUserUnqId);
                if(unqPos >= 0) {
                    arrSelectedUsersUnqId.splice(unqPos, 1);
                }
            }
            clearAllSelectedUsers();
        }

        debugAll('.btnRemoveUserFromSelectedContact');
    });


    /**
     * START TEMPALTE WORK
     */

    $('#lstTemplates').on('change', function(){
        var thisObj = $(this);

        var selectedOption = $(this).find('option:selected');

        var templateBody = atob(selectedOption.attr('data-templateBody'));
        var templateTitle = atob(selectedOption.attr('data-templateTitle'));
        var languageSelected = selectedOption.attr('data-languageSelected');
        var isReschedule = selectedOption.attr('data-isReschedule');
        
        
        var flagSMS = selectedOption.attr('data-flagSMS');
        var flagSMSTimingId = selectedOption.attr('data-flagSMSTimingId');
        var flagCall = selectedOption.attr('data-flagCall');
        var flagCallTimingId = selectedOption.attr('data-flagCallTimingId');
        var flagEmail = selectedOption.attr('data-flagEmail');
        var flagEmailTimingId = selectedOption.attr('data-flagEmailTimingId');

        $('#lstLanguage').val(languageSelected);
        $('#taAppoinmentTemplateBody').html(templateBody);
        $('#txtAppointmentType').val(templateTitle);
        if(isReschedule == "Y") {
            $('#chkIsReschedule').prop('checked', true);
        }
        else {
            $('#chkIsReschedule').prop('checked', false);
        }

        // removing previous checks
        $('.clickReminderSlotCheckBox').prop('checked', false);
        $('.clickReminderSlotCheckBox').parent().parent().parent().removeClass('background-color-red');
        $('.flagCheckReminderSlots').prop('checked', false);
        $('.flagHeadTimingChecks').prop('checked', false);

        var arrSMSTimingId = [];
        if(!_.isEmpty(flagSMSTimingId)) {
            arrSMSTimingId = _.split(flagSMSTimingId, ',');
            _.map(arrSMSTimingId, function(timingId) {
                var checkBoxObj = $('#chkFlagTimeSlot_SMS_' + timingId);
                if(!_.isUndefined(checkBoxObj)) {
                    checkBoxObj.prop('checked', true);

                    updateMainReminderFlags();
                    updateEachAllSelectedFlag(checkBoxObj);
                }
            })
        }

        var arrCALLTimingId = [];
        if(!_.isEmpty(flagCallTimingId)) {
            arrCALLTimingId = _.split(flagCallTimingId, ',');
            _.map(arrCALLTimingId, function(timingId) {
                var checkBoxObj = $('#chkFlagTimeSlot_CALL_' + timingId);
                if(!_.isUndefined(checkBoxObj)) {
                    checkBoxObj.prop('checked', true);
                    updateMainReminderFlags();
                    updateEachAllSelectedFlag(checkBoxObj);
                }
            })
        }

        var arrEMAILTimingId = [];
        if(!_.isEmpty(flagEmailTimingId)) {
            arrEMAILTimingId = _.split(flagEmailTimingId, ',');
            _.map(arrEMAILTimingId, function(timingId) {
                var checkBoxObj = $('#chkFlagTimeSlot_EMAIL_' + timingId);
                if(!_.isUndefined(checkBoxObj)) {
                    checkBoxObj.prop('checked', true);
                    updateMainReminderFlags();
                    updateEachAllSelectedFlag(checkBoxObj);
                }
            })
        }

    });

    $('#lstInsertFields').on('change', function(){
        var selectedInsertFieldValue = $(this).val();
        if(selectedInsertFieldValue != "") {
            selectedInsertFieldValue = '{' + selectedInsertFieldValue + '}';
            var oldTaContent = $('#taAppoinmentTemplateBody').val();
            var newTaContent = oldTaContent + selectedInsertFieldValue;
            $('#taAppoinmentTemplateBody').val(newTaContent);
        }
        $('#lstInsertFields').val('');
    });

    /**
     * END TEMPALTE WORK
     */


    /**
     * START CHECKBOX
     */
    
    $('.flagCheckReminderSlots').on('click', function() {
        var thisCheckBox = $(this);

        var reminderId = thisCheckBox.attr('data-reminderid');

        var flagCheck = thisCheckBox.prop('checked');

        var hidCheckBoxType = $('#hidCheckBoxType').val();

        var arrReminderTypes = hidCheckBoxType.split(',');

        if(arrReminderTypes.length > 0){
            $.each(arrReminderTypes, function(index, eachReminderType){
                var checkBox = $('#chkFlagTimeSlot_' + eachReminderType + '_' + reminderId);

                if(flagCheck) {
                    checkBox.prop('checked', true);
                    checkBox.parent().parent().parent().addClass('background-color-red');

                }
                else {
                    checkBox.prop('checked', false);
                    checkBox.parent().parent().parent().removeClass('background-color-red');
                }
            })
        }
        updateMainReminderFlags();
        updateEachAllSelectedFlag($(this));
    });

    $('.clickReminderSlotCheckBox').on('click', function(){
        updateMainReminderFlags();
        updateEachAllSelectedFlag($(this));
    });
    /**
     * END CHECKBOX
     */
});

function gatherAllFormInfo() {
    $('#selectedUsersData').val(JSON.stringify(arrUsersAdded));
    return true;
}

function updateEachAllSelectedFlag(thisCheckBox) {

    var reminderId = thisCheckBox.attr('data-reminderSlotId');
    var reminderType = thisCheckBox.attr('data-reminderType');

    var hidCheckBoxType = $('#hidCheckBoxType').val();

    var arrReminderTypes = hidCheckBoxType.split(',');

    if(arrReminderTypes.length > 0){
        var flagNeedToUpdateLeftCheckBox = true;
        $.each(arrReminderTypes, function(index, eachReminderType){
            var eachCheckBoxInRow = $('#chkFlagTimeSlot_' + eachReminderType + '_' + reminderId);

            var eachCheckboxInRowChecked = eachCheckBoxInRow.prop('checked');

            if(!eachCheckboxInRowChecked) {
                flagNeedToUpdateLeftCheckBox = false;
            }
        });

        if(flagNeedToUpdateLeftCheckBox) {
            $('#chkFlagCheckAllReminderSlot' + reminderId).prop('checked', true);
            $('.tdBoxReminderCheckbox' + reminderId).addClass('background-color-red');
        }
        else {
            $('#chkFlagCheckAllReminderSlot' + reminderId).prop('checked', true);
            $('.tdBoxReminderCheckbox' + reminderId).removeClass('background-color-red');
        }
    }
}


function updateMainReminderFlags() {
    var hidCheckBoxType = $('#hidCheckBoxType').val();

    var arrReminderTypes = hidCheckBoxType.split(',');

    if(arrReminderTypes.length > 0){
        $.each(arrReminderTypes, function(index, eachReminderType){
            var arrObjAllCheckBoxReminderType = $(':checkbox[data-reminderType="'+eachReminderType+'"]');
            
            var flagNeedToUpdateMainRemiderFlag = false;
            if(arrObjAllCheckBoxReminderType.length > 0) {
                $.each(arrObjAllCheckBoxReminderType, function(eachIndex, eachCheckBoxReminder){
                    var flagCheck = $(eachCheckBoxReminder).prop('checked');

                    if(flagCheck) {
                        flagNeedToUpdateMainRemiderFlag = true;
                    }
                })
            }

            if(flagNeedToUpdateMainRemiderFlag) {
                $('#chkFlag' + eachReminderType).prop('checked', true);
            }
            else {
                $('#chkFlag' + eachReminderType).prop('checked', false);
            }
        });
    }
}


function debugAll (fromwhere) {

    console.log("fromwhere=============== :: ", fromwhere);
    console.log("arrCurrentSearchResult :: ", arrCurrentSearchResult);
    console.log("arrUserSelected :: ", arrUserSelected);
    console.log("arrUsersAdded :: ", arrUsersAdded);
    console.log("arrSelectedUsersUnqId :: ", arrSelectedUsersUnqId);
}


function clearAllSelectedUsers() {
    var tmp = arrUsersAdded;
    generateSelectedTableData(tmp, false);
}


function generateSelectedTableData(arrSelectedResultSet, flagAddIntoAddedArray) {
    selectedUsersTable.clear().draw();

    if(typeof flagAddIntoAddedArray == 'undefined') {
        flagAddIntoAddedArray = true;
    }

    if(arrSelectedResultSet.length > 0) {
        $.each(arrSelectedResultSet, function(index, eachSelectedUsers) {

            var id = eachSelectedUsers.id;
            var contactType = eachSelectedUsers.contactType;
            var strUnqId = id + '--' + contactType;
            
            if(flagAddIntoAddedArray) {
                arrUsersAdded.push(eachSelectedUsers);
                arrSelectedUsersUnqId.push(strUnqId);
            }
        });
        
        $.each(arrUsersAdded, function(index, objUserElement){
            addEntryInSelectedTable(objUserElement);
        });
    }
}

function addEditable() {
    /* Apply the jEditable handlers to the table */
    $('.editableClass').editable(function(value, setting) {
        var objThis = $(this);

        var thisContactId = objThis.parent().parent().find('a').attr('data-cardCode');
        var thisContactType = objThis.parent().parent().find('a').attr('data-contactType');

        var selectedClass = "";

        if(objThis.hasClass('editableFullName')) {
            selectedClass = 'fullName';
        }
        else if(objThis.hasClass('editableEmail')) {
            selectedClass = 'email';
        }
        else if(objThis.hasClass('editablePhoneNumber')) {
            selectedClass = 'phoneNumber';
        }

        if(arrUsersAdded.length > 0) {
            $.each(arrUsersAdded, function(index, objAddedUsers) {
                if(thisContactId == objAddedUsers.cardCode && thisContactType == objAddedUsers.contactType) {
                    switch(selectedClass) {
                        case "fullName":
                            objAddedUsers.fullName = value;
                        break;
                        case "email":
                            objAddedUsers.email = value;
                        break;
                        case "phoneNumber":
                            objAddedUsers.phoneNumber = value;
                        break;
                    }
                }
            });
        }

        return value;
    }, {
        type    : 'text',
        submit  : 'OK',
        placeholder: '-'
    });
}

function addEntryInSelectedTable(objUserData) {
    var fullName = "";
    var email = "";
    var phoneNumber = "";
    var contactType = objUserData.contactType;
    var id = objUserData.cardCode;

    if(typeof objUserData.fullName != 'undefined' && objUserData.fullName != "") {
        fullName = objUserData.fullName;
    }
    if(typeof objUserData.email != 'undefined' && objUserData.email != "") {
        email = objUserData.email;
    }
    if(typeof objUserData.phoneNumber != 'undefined' && objUserData.phoneNumber != "") {
        phoneNumber = objUserData.phoneNumber;
    }

    selectedUsersTable.row.add([
        '<a class="text-warning btnRemoveUserFromSelectedContact" href="javaScript:;" data-contactType="' + contactType + '" data-cardCode="' + id + '"><i class="fa fa-times" aria-hidden="true"></i></a>',
        '<span class="editableClass editableFullName">' + fullName + '</span>',
        '<span class="editableClass editableEmail">' + email + '</span>',
        '<span class="editableClass editablePhoneNumber">' + phoneNumber + '</span>'
    ]).draw(false);
}




function clearAllSelectedSearchedUsers() {
    arrUserSelected = [];
    var tmp = arrCurrentSearchResult;
    generateSearchTableData(tmp);
}


function generateSearchTableData(arrSearchResult) {
    searchTable.clear().draw();
    arrCurrentSearchResult = [];
    if(arrSearchResult.length > 0) {
        $.each(arrSearchResult, function(index, eachRecord) {

            arrCurrentSearchResult.push(eachRecord);

            var id = eachRecord.cardCode;
            var contactType = eachRecord.contactType;

            searchTable.row.add([
                '<div class="i-checks">' + 
                    '<label>' + 
                        '<input type="checkbox" value="Y" class="addThisContactInList" data-contactType="' + contactType + '" data-cardCode="' + id + '">' + 
                    '</label>' + 
                '</div>',
                eachRecord.fullName,
                eachRecord.email,
                eachRecord.phoneNumber
            ]).draw(false);
        });
    }
}


function searchCustomersFromDatabase() {
    var queryString = $('#txtSearchForCustomers').val();

    if(queryString != "") {
        arrCurrentSearchResult = [];
        var urlToGetData = hidAbsUrl + '/contacts/searchContact/' + encodeURIComponent(queryString);

        $.ajax({
            url: urlToGetData,
            method: "GET",
            data: {},
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
                        case "FETCH":
                            var usersRecords = data;
                            if(usersRecords.length > 0) {
                                generateSearchTableData(usersRecords);
                            }
                        break;
                    }
                }
            }
        });
    }
}


function getSelectedUserDetailForUpdateReminder() {
    var selectedReminder = $('#selectedUsersDataFromEdit').val();

    if(selectedReminder != "") {
        
        var objSelectedReminder = JSON.parse(selectedReminder);

        objSelectedReminder = objSelectedReminder[0];

        arrUsersAdded.push(objSelectedReminder);

        console.log("objSelectedReminder :: ", objSelectedReminder);

    }

}