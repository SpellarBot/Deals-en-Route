$(document).ready(function () {
     $(".select2_demo_2").select2({
            placeholder: "Select Category"
     });
      var year = (new Date).getFullYear();
      $('#input-group-datepicker').datepicker({
        endDate: new Date(year, 0, 0),
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        dateFormat: 'd/m/y',
        autoclose: true,     
       
    });
    $('#usertemplate').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,

        oLanguage: {sEmptyTable: "No records found"},
        columns: [
            {data: 'id', name: 'id'},
             {data: 'full_name', name: 'full_name'},
            {data: 'email', name: 'email'},
           {data: 'gender', name: 'gender'},
            {data: 'dob', name: 'dob'},

            {
                mRender: function (data, type, row) {
                    hidAbsUrl = $('#hidAbsUrl').val();
                    if (row.is_active == 1) {
                        var active= '<a title="active" class="editor_active" href="" data-value=' + row.is_active + '  data-key=' + row.id + '><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    } else {
                      var active= '<a title="inactive" class="text-danger editor_active" href="" data-value=' + row.is_active + ' data-key=' + row.id + '><i class="fa fa-eye-slash" aria-hidden="true"></i></a>';
                    }
                    return '<center>\n\<a class="text-info"  title="edit" href=' + hidAbsUrl + '/admin/users/' + row.id + '/edit><i class="fa fa-pencil" aria-hidden="true"></i></a> \n\
                     ' +active +'\n\ <a class="text-danger editor_remove" title="delete user" href="" data-key=' + row.id + '><i class="fa fa-times" aria-hidden="true"></i></a>\n\
                      \n\ <a  title="change password" href=' + hidAbsUrl + '/admin/password/reset/' + btoa(row.id) + '  data-key=' + row.id + '><i class="fa fa-lock" aria-hidden="true"></i></a></center>';
            ;
         
                },
                orderable: false,
                searchable: false,
                className: "center",
            },
            
        ],

    });


    // Delete a record
    $('#usertemplate').on('click', 'a.editor_remove', function (e) {

        e.preventDefault();
        if (confirm("Are you sure you want to delete record? "))
        {
            var table = $('#usertemplate').DataTable();
            var parent = $(this).attr('data-key');
            $.ajax({
                url: hidAbsUrl + "/admin/users/" + parent,
                type: 'DELETE',
            }).done(function (result_data) {
                var objErrorToastNotication = {
                    message: "User deleted successfully"
                };
                setToastNotification(objErrorToastNotication);

                table.row($(this).parents('tr')).remove().draw(false);

            });
            return false;
        }
    });

    // Active a record
    $('#usertemplate').on('click', 'a.editor_active', function (e) {

        e.preventDefault();
        var table = $('#usertemplate').DataTable();
        var parent = $(this).attr('data-key');
        var value = $(this).attr('data-value');
        if (value == 1) {
            var message = 'Are you sure you want to deactive this record?';
        } else {
            var message = 'Are you sure you want to active this record?';
        }
        if (confirm(message))
        {
            $.ajax({
                url: hidAbsUrl + "/admin/users/active",
                data: {'id': parent, 'value': value},
                type: 'GET',
            }).done(function (result_data) {
                var objErrorToastNotication = {
                    message: "User updated successfully"
                };
                setToastNotification(objErrorToastNotication);

                table.row($(this).parents('tr')).remove().draw(false);

            });
            return false;
        }
    });


   //on click row
    $('#usertemplate tbody').on('click', 'tr td:not(:last-child)', function () {
         var table = $('#reminderDashboardTable').DataTable();

        var data = $(this).parent('tr').find('.editor_remove').attr('data-key');
        window.location.replace("users/"+data);
    } );

 

});



    