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

        <h2>Currently Active Offer</h2>

        <table id="redeemed" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Offer Name</th>
                    <th>Code</th>
                    <th>Created</th>
                    <th>Redeemed</th>
                    <th>Active</th>
                    <th>Valid Until</th>
                    <th>Radius</th>
                    <th>Geofencing Area</th>
                </tr>
            </thead>
            <tbody>
                @foreach($active_list as $row)
                <tr>
                    <td>{{$row->coupon_name}}</td>
                    <td>{{$row->coupon_code}}</td>
                    <td>{{$row->coupon_redeem_limit}}</td>
                    <td>{{$row->redeemed}}</td>
                    <td>{{$row->coupon_redeem_limit - $row->redeemed}}</td>
                    <td>{{$row->coupon_end_date}}</td>
                    <td>{{$row->coupon_radius}}</td>
                    <td>{{$row->coupon_notification_sqfeet}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <h2>Additional Items Purchased</h2>
        <table id="table3" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Purchased On</th>
                    <th>Type</th>
                    <th>Quanity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($additional_list as $row)
                <tr>
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->addon_type }}</td>
                    <td>{{$row->quantity}}</td>
                    <td>$ {{$row->quantity * 4.99}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>

