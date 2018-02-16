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

        <h2>User List</h2>

        <table>
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Offer</th>
                    <th>Coupon Code</th>
                    <th>Redeemed On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $row)
                <tr>
                    <td>{{$row->coupon_name}}</td>
                    <td>{{$row->coupon_detail}}</td>
                    <td>{{$row->coupon_code}}</td>
                    <td>{{$row->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>

