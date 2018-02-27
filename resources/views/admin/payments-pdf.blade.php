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

        <h2>Payment List</h2>

        <table>
            <thead>
                <tr>
                    <th>Payee</th>
                    <th>Paid Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paylist as $row)
                <tr>
                    <td>{{$row->vendor_name}}</td>
                    <td style="width:100px;">{{date("m-d-Y", strtotime($row->created_at))}}</td>
                    <td>$ {{$row->payment_amount}}</td>
                    <td>{{$row->payment_type}}</td>
                    <td>{{$row->transaction_id}}</td>
                    <td><span class="text-success">{{$row->payment_status}}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </table>

</body>
</html>

