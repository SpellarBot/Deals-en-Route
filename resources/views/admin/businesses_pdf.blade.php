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

        <h2>Business List</h2>

        <table>
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Subscribed Package</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($business_list as $row)
                <tr>
                    <td>{{$row->vendor_name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->vendor_phone}}</td>
                    <td>{{$row->stripe_plan}}</td>
                    <td>{{($row->is_activeActive == 1) ? 'Not Active' : 'Active'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>

