
$(document).ready(function () {

    $('#usertemplate').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,

        oLanguage: {sEmptyTable: "No records found"},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'email', name: 'email'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'dob', name: 'dob'},

            {
                mRender: function (data, type, row) {
                    hidAbsUrl = $('#hidAbsUrl').val();

                    return '<a class="text-info" href=' + hidAbsUrl + '/mastertemplates/' + row.recid + '/edit><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                },
                orderable: false,
                searchable: false,
                className: "center",
            },

            {
                mRender: function (data, type, row) {

                    return '<a class="text-warning editor_remove" href="" data-key=' + row.recid + '><i class="fa fa-times" aria-hidden="true"></i></a>';
                },
                className: "center",
                orderable: false,
                searchable: false
            },
        ],

    });


    // Delete a record
    $('#mastertemplates').on('click', 'a.editor_remove', function (e) {

        e.preventDefault();
        if (confirm("Are you sure you want to delete template "))
        {
            var table = $('#mastertemplates').DataTable();
            var parent = $(this).attr('data-key');
            $.ajax({
                url: hidAbsUrl + "/mastertemplates/" + parent,
                type: 'DELETE',
            }).done(function (result_data) {
                var objErrorToastNotication = {
                    message: "Templates deleted successfully"
                };
                setToastNotification(objErrorToastNotication);
                table.row($(this).parents('tr')).remove().draw(false);

            });
            return false;
        }
    });




    $('.addfields #fields').on('change', function (e) {

        if ($(this).val() != '') {
            var value = "{" + $(this).val() + "}";
            var quote = $('#bodyemail').val();
            $('#bodyemail').val(quote + value);

        }
    });

    //  on click of rows
    $('.select-rowcheckbox').on('click', function (e) {
        var dataid = $(this).parents('tr').find('.select-colcheckbox').attr('data');

        if (this.checked) {
            // Iterate each checkbox
            $(this).parents('tr').find(':checkbox').prop('checked', this.checked);
            $(this).parents('table').find('thead :checkbox').prop('checked', this.checked);
        } else {
            $(this).parents('tr').find(':checkbox').prop('checked', this.checked);
        }
        if ($(this).parents('table').find("tbody .select-colcheckbox[data='" + dataid + "']:checked").length == 0) {
            $(this).parents('table').find('thead :checkbox').prop('checked', false);
        }

    });

    //  on click of columns
    $('.select-colcheckboxhead').on('click', function (e) {
        var dataid = $(this).attr('data');
        if (this.checked == false) {
            $(this).parents('table').find("tbody .select-colcheckbox[data='" + dataid + "']").prop('checked', this.checked);

        }
    });

    //  on click of head columns
    $('.select-colcheckbox').on('click', function (e) {
        var dataid = $(this).attr('data');
        //for column head
        if ($(this).parents('table').find("tbody .select-colcheckbox[data='" + dataid + "']:checked").length == 0)
        {
            $(this).parents('table').find("thead .select-colcheckboxhead[data='" + dataid + "']").prop('checked', false);
        } else {
            $(this).parents('table').find("thead .select-colcheckboxhead[data='" + dataid + "']").prop('checked', true);
        }
        //for row head
        if ($(this).parents('tr').find(".select-colcheckbox:checked").length == 3)
        {
            $(this).parents('tr').find(".select-rowcheckbox").prop('checked', true);
        } else {
            $(this).parents('tr').find(".select-rowcheckbox").prop('checked', false);
        }
    });


});



    