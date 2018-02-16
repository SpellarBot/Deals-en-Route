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
            <th>Name</th>
            <th>Email</th>
            <th class="sort-numeric">Age</th>
            <th>Gender</th>
            <th class="sort-numeric">Coupons Redeemed</th>
            <th>SignUp Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user_list as $row)
        <tr>
            <td>{{$row->first_name ?:'-'}} {{$row->last_name}}</td>
            <td>t{{$row->email ?:'-'}}</td>
            <td>{{$row->age ?:'-'}}</td>
            <td>{{$row->gender ?:'-'}}</td>
            <td>{{$row->coupons ?:'-'}}</td>
            <td>{{($row->fb_token != '') ?'facebook':''}}{{($row->google_token!= '') ?'google':''}}{{($row->twitter_token != '') ?'twitter':''}}</td>
            <td><span class="active">Active</span></td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

