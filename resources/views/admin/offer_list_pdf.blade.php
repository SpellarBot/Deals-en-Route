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

        @foreach($user_list as $row)
        <div class="well clearfix">
            <h2 class="col-xs-12 mt-0 mb-20"><strong>{{$row->first_name}} {{$row->last_name}}</strong></h2>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <p><strong>Gender :</strong> {{$row->gender}}</p>
                <p><strong>Age :</strong> {{$row->age}} Years Old</p>
                <p><strong>Email :</strong> {{$row->email}}</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <p><strong>Sign Up Type :</strong> {{($row->fb_token != '') ?'facebook':''}}{{($row->google_token!= '') ?'google':''}}{{($row->twitter_token != '') ?'twitter':''}}</p>
                <p><strong>Coupons Redeemed :</strong> {{$row->coupons}}</p>
                <p><strong>Status :</strong> <span class="text-success" @if($row->is_active != 1)style="color:red;" @endif>{{($row->is_active == 1) ?'Active':'Inactive'}}</span></p>

            </div>

        </div>
        @endforeach
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
                    <td>{{date("m-d-Y", strtotime($row->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>

