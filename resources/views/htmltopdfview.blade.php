<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="middle" style="padding:20px 30px 20px; border-bottom:1px solid #000;"><img src="{{ base_path('public/frontend/img/logo.png') }}" alt="" style="width:100px;height: 100px;"></td>
        <td align="right" valign="middle" style="padding:20px 30px 20px; border-bottom:1px solid #000; font-size:25px; line-height:30px; color:#666;"> Invoice </td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f5f5f5" style="margin:25px 0 40px;">
    <tr>
        <td align="center" valign="top" width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="padding:20px; border-bottom:1px solid #fff;"><span style="color:#999; font-size:15px; font-weight:bold; line-height:20px;">Email ID</span><br />
                        <span style="color:#09F; font-size:17px;">{{ $details['vendor']['email'] }}</span></td>
                </tr>
                <tr>
                    <td style="padding:20px; border-bottom:1px solid #fff;"><span style="color:#999; font-size:15px; font-weight:bold; line-height:20px;">Date</span><br />
                        <span style="color:#09F; font-size:17px;">{{ date('d-m-Y') }}</span></td>
                </tr>
                <tr>
                    <td style="padding:20px; border:1px solid #fff;"><span style="color:#999; font-size:15px; font-weight:bold; line-height:20px;">Order ID</span><br />
                        <span style="color:#09F; font-size:17px;">{{ $details['transaction_id'] }}</span></td>
                </tr>
            </table></td>
        <td style="padding:20px; border-right:1px solid #fff; border-left:1px solid #fff;" width="35%"><span style="color:#999; font-size:15px; font-weight:bold; line-height:20px;">Billed To {{ $details['vendor']['billing_businessname'] }}</span><br />
            <span style="color:#000; font-size:17px;">{{ $details['vendor']['billing_home'] }}<br />
                {{ $details['vendor']['billing_city'] }}<br />
                {{ $details['vendor']['country_name'] }} , {{ $details['vendor']['billing_zip'] }}</span></td>
        <td align="right" style="padding:20px"><span style="color:#999; font-size:15px; font-weight:bold; line-height:20px;">Total</span><br />
            <span style="color:#000; font-size:25px; font-weight:bold;">$ {{ number_format($details['total_amount'],2)}}</span></td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr bgcolor="#f5f5f5">
        <td style="padding:10px 15px; color:#777; font-weight:bold; font-size:17px;">Item</td>
        <td style="padding:10px 15px; color:#777; font-weight:bold; font-size:17px;">Type</td>
        <td style="padding:10px 15px; color:#777; font-weight:bold; font-size:17px;" width="140" align="right">Price</td>
    </tr>
    @foreach($details['items'] as $item)
    <tr>
        <td style="padding:25px 15px 10px; font-size:16px;">{{ $item['item_name'] }}</td>
        <td style="padding:25px 15px 10px; font-size:16px;">{{ $item['item_type'] }}</td>
        <td style="padding:25px 15px 10px; font-size:16px; font-weight:bold;" align="right">$ {{ number_format($item['amount'],2) }}</td>
    </tr>
    @endforeach
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0;">
    <tr>
        <td align="right" style="border-top:1px solid #aaa;border-bottom:1px solid #aaa;border-right:1px solid #aaa; padding:15px 25px; font-size:16px; font-weight:bold; color:#999;">TOTAL</td>
        <td align="right" width="140" style="border-top:1px solid #aaa;border-bottom:1px solid #aaa; padding:15px; font-size:22px; font-weight:bold;">$ {{ number_format($details['total_amount'],2)}}</td>
    </tr>
</table>