// Demo datatables
// -----------------------------------


(function(window, document, $, undefined) {

    $(function() {

        /*-----------------Users-----------------*/
        var Users = $('#users').dataTable({
            'paging': true, // Table pagination
            'ordering': true, // Column ordering
            'info': true, // Bottom left status text
            'responsive': true, // https://datatables.net/extensions/responsive/examples/
            // Text translation options
            // Note the required keywords between underscores (e.g _MENU_)
            oLanguage: {
                sSearch: 'Search User:',
                sLengthMenu: '_MENU_ records per page',
                info: 'Showing page _PAGE_ of _PAGES_',
                zeroRecords: 'Nothing found - sorry',
                infoEmpty: 'No records available',
                infoFiltered: '(filtered from _MAX_ total records)'
            },

            buttons: [{
                extend: 'csv',
                className: 'btn-sm'
            }, {
                extend: 'excel',
                className: 'btn-sm',
                title: 'XLS-File'
            }, {
                extend: 'pdf',
                className: 'btn-sm',
                title: $('title').text()
            }, {
                extend: 'print',
                className: 'btn-sm'
            }]
        });
        var inputSearchClass = 'datatable_input_col_search';
        var columnInputs = $('tfoot .' + inputSearchClass);

        // On input keyup trigger filtering
        columnInputs.keyup(function() {
            UserManagement.fnFilter(this.value, columnInputs.index(this));
        });

        /*-----------------Redeemed-----------------*/
        var Redeemed = $('#redeemed').dataTable({
            'paging': true, // Table pagination
            'ordering': true, // Column ordering
            'info': true, // Bottom left status text
            'responsive': true, // https://datatables.net/extensions/responsive/examples/
            // Text translation options
            // Note the required keywords between underscores (e.g _MENU_)
            oLanguage: {
                sSearch: 'Search:',
                sLengthMenu: '_MENU_ records per page',
                info: 'Showing page _PAGE_ of _PAGES_',
                zeroRecords: 'Nothing found - sorry',
                infoEmpty: 'No records available',
                infoFiltered: '(filtered from _MAX_ total records)'
            },

            buttons: [{
                extend: 'csv',
                className: 'btn-sm'
            }, {
                extend: 'excel',
                className: 'btn-sm',
                title: 'XLS-File'
            }, {
                extend: 'pdf',
                className: 'btn-sm',
                title: $('title').text()
            }, {
                extend: 'print',
                className: 'btn-sm'
            }]
        });
        var inputSearchClass = 'datatable_input_col_search';
        var columnInputs = $('tfoot .' + inputSearchClass);

        // On input keyup trigger filtering
        columnInputs.keyup(function() {
            Survey.fnFilter(this.value, columnInputs.index(this));
        });


        // Pie chart
        // -----------------------Remaining Deals-----------------------
//        var remainingDeals = {
//            labels: [
//                'Remaining',
//                'Completed'
//            ],
//            datasets: [{
//                data: [100, 50],
//                backgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ],
//                hoverBackgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ]
//            }]
//        };
//
//        var pieOptions = {
//            legend: {
//                display: false
//            }
//        };
//        var piectx = document.getElementById('remainingDeals').getContext('2d');
//        var pieChart = new Chart(piectx, {
//            data: remainingDeals,
//            type: 'pie',
//            options: pieOptions
//        });
//        // -----------------------Remaining Miles-----------------------
//        var remainingMiles = {
//            labels: [
//                'Remaining',
//                'Completed'
//            ],
//            datasets: [{
//                data: [100, 30],
//                backgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ],
//                hoverBackgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ]
//            }]
//        };
//
//        var pieOptions = {
//            legend: {
//                display: false
//            }
//        };
//        var piectx = document.getElementById('remainingMiles').getContext('2d');
//        var pieChart = new Chart(piectx, {
//            data: remainingMiles,
//            type: 'pie',
//            options: pieOptions
//        });
//        // -----------------------Remaining Geofencing-----------------------
//        var remainingGeofencing = {
//            labels: [
//                'Remaining',
//                'Completed'
//            ],
//            datasets: [{
//                data: [100, 75],
//                backgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ],
//                hoverBackgroundColor: [
//                    '#4bba6d',
//                    '#3b5898'
//                ]
//            }]
//        };
//
//        var pieOptions = {
//            legend: {
//                display: false
//            }
//        };
//        var piectx = document.getElementById('remainingGeofencing').getContext('2d');
//        var pieChart = new Chart(piectx, {
//            data: remainingGeofencing,
//            type: 'pie',
//            options: pieOptions
//        });
    });

})(window, document, window.jQuery);