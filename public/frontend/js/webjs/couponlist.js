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

$().ready(function() {
       
        window.operateEvents = {
                'click .view': function(e, value, row, index) {
                        info = JSON.stringify(row);

                        swal('You click view icon, row: ', info);
                        console.log(info);
                },
                'click .edit': function(e, value, row, index) {
                        info = JSON.stringify(row);

                        swal('You click edit icon, row: ', info);
                        console.log(info);
                },
                'click .remove': function(e, value, row, index) {
                 
                info = JSON.stringify(row);
                conf=   confirm("Do you ready want to delete this row?");
                if (conf === true) {
                  $('#loadingDiv').show();
                    axios.delete($('#hidAbsUrl').val()+'/coupon/' + row._id)
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

                formatShowingRows: function(pageFrom, pageTo, totalRows) {
                        //do nothing here, we don't want to show the text "showing x of y from..."
                },
                formatRecordsPerPage: function(pageNumber) {
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

        $(window).resize(function() {
            $('#loadingDiv').hide();
                $table.bootstrapTable('resetView');
        });
});


