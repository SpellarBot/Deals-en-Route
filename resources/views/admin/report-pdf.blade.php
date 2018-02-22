<html>
    <head>
        <style>
            *{
                font-size: 13px;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>

        <h2>Report-content List</h2>

        <table>
            <thead>
                <tr>
                    <th>Reported By</th>
                    <th>Content Owner</th>
                    <th class="sort-numeric">Comment</th>
                    <th>Reason</th>
                    <th>Reported On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report_list as $row)
                <tr>
                    <td>{{$row->c_firstname ?:'-'}} {{$row->c_lastname}}</td>
                    <td>{{$row->o_firstname ?:'-'}} {{$row->o_lastname}}</td>
                    <td>{{$row->comment_desc ?:'-'}}</td>
                    <td>{{$row->report_content ?:'-'}}</td>
                    <td>{{$row->created_at ?:'-'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>

