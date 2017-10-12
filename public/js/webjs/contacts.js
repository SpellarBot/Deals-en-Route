
$(document).ready(function () {
    
var year = (new Date).getFullYear();
      $('#input-group-datepicker').datepicker({
      
        endDate: new Date(year, 0, 0),

        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        dateFormat: 'yy-mm-dd',
        autoclose: true,     
       
    });
    
    $('#contactsdatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
         
        oLanguage: { sEmptyTable: "No records found" },
        columns: [

            {data: 'caseNo', name: 'caseNo'},
            {data: 'fullName', name: 'fullName'},
            {data: 'email', name: 'email'},
            {data: 'phoneNumber', name: 'phoneNumber'},

            {
                mRender: function (data, type, row) {
                    hidAbsUrl = $('#hidAbsUrl').val();

                    return '<a class="text-info" href=' + hidAbsUrl + '/contacts/' + row.cardCode + '/edit><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                },
                orderable: false,
                searchable: false,
                className: "center",
            },

            {
                mRender: function (data, type, row) {
                   if(!$.isNumeric(row.cardCode)) {    
                    return '<a class="text-warning editor_remove" href="" data-key=' + row.cardCode + '><i class="fa fa-times" aria-hidden="true"></i></a>';
                   }
                   return '';
                    },
                className: "center",
                orderable: false,
                searchable: false
            },
        ],

    });


    // Delete a record
    $('#contactsdatatable').on('click', 'a.editor_remove', function (e) {

        e.preventDefault();
        if (confirm("Are you sure you want to delete contact "))
        {
            var table = $('#contactsdatatable').DataTable();
            var parent = $(this).attr('data-key');
            $.ajax({
                url: hidAbsUrl + "/contacts/" + parent,
                type: 'DELETE',
            }).done(function (result_data) {
                        var objErrorToastNotication = {
                                    message: "Contacts deleted successfully"
                                };
                                setToastNotification(objErrorToastNotication);
                table.row($(this).parents('tr')).remove().draw(false);

            });
            return false;
        }
    });
    
       
  $('#address-book').on('hidden.bs.modal', function (e) {
       $(".add-address-book").find('.alert-danger').hide();
       $(".add-address-book").find(".import_error_message").html("");
       $('#importcontactform')[0].reset();
       
    
    });

    $('form#importcontactform').submit(function (e) {

        e.preventDefault();

        var formData = new FormData($(this)[0]);
        $.ajax({
            url: hidAbsUrl + "/import-csv",
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,

            success: function (data) {
        
                  $('#contactsdatatable').DataTable().draw();
                $(".add-address-book").find('.alert-danger').hide();
                $(".import_error_message").html("");
                if (data.error == 2) {
                    var errors = data.errormessage;

                    $(".add-address-book").find('.alert-danger').show();
                    $(".import_error_message").html(errors);


                } else if (data.error == 1) {
                    var errors = data.errormessage;
                 
                    $(".contactindex").find('.alertcontact').show();
                    $(".import_error_message").html(errors);
                 $('#formclose').trigger('click');
                } else if (data.error == 0) {
                    $('#formclose').trigger('click');
                      $(".contactindex").find('.alertcontact').hide();
                    var objErrorToastNotication = {
                        message: data.message
                    };
                    setToastNotification(objErrorToastNotication);
                }
            },
        });
    })

  

});



    