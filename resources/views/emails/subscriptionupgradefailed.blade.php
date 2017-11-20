@extends('vendor.mail.html.layout')
@section('content')

<tr>
    <td bgcolor="#ffffff" align="center" valign="top" style="padding:30px;" class="pa"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>

                <td align="center" valign="top" style="font-family:'Lato', Arial, sans-serif; font-size:19px; color:#777777; line-height:22px; font-weight:bold; padding:0 0 25px;" class="pb">Deals en Route</td>
            </tr>
            <tr>
                <td align="left" valign="top" style="font-family:'Lato', Arial, sans-serif; font-size:15px; color:#777777; line-height:20px; padding:0 0 20px;">“Oh no! Your upgrade failed. Please try again or contact our customer service at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a> if problems persist.”</td>
            </tr>
            <tr>
                <td align="center" valign="top" style="padding:0 0 20px;"><table width="135" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#3b5997" style="background-color:#3b5997;">
                        <tr>
                            <td height="35" align="center" valign="middle" style="font-family:'Lato', Arial, sans-serif; font-size:14px; color:#ffffff;"><a href="<?php echo URL::to('/'); ?>" target="_blank" style="text-decoration:none; color:#ffffff; display:block; line-height:32px;">Login</a></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="font-family:'Lato', Arial, sans-serif; font-size:15px; color:#777777; line-height:20px;">P.S. if you didn't request this email, you  may safely ignore it. </td>
            </tr>
        </table></td>
</tr>
</table></td>
</tr>
<tr>
    <td align="center" valign="top" style="padding:30px 15px; border-bottom:1px solid #bfc7cb;" class="pa"><table width="400" border="0" cellspacing="0" cellpadding="0" align="center" class="wrap">
            <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="left" class="wrap">
                        <tr>
                            <td align="center" valign="top" style="font-family:'Lato', Arial, sans-serif; font-size:14px; color:#777777; line-height:18px;" class="pb">Keep in touch with us:</td>
                        </tr>
                    </table>
                    <table width="230" border="0" cellspacing="0" cellpadding="0" align="right" class="wrap">
                        <tr>
                            <td align="center" valign="top"><table width="230" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <?php $insta = \Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/instagram.png' ?>
                                    <?php $fb = \Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/facebook.png' ?>
                                    <?php $twitter = \Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/twitter.png' ?>
                                    <?php $you = \Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/youtube.png' ?>
                                    <?php $gplus = \Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/gplus.png' ?>

                                    <tr>
                                        <td width="18" align="center" valign="middle" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="<?php echo $insta; ?>" width="18" alt="insta" border="0" style="display:block; max-width:18px;" /></a></td>
                                        <td height="18" style="font-size:0px; line-height:0px;">&nbsp;</td>
                                        <td width="18" align="center" valign="middle" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="<?php echo $fb; ?>" width="18" alt="fb" border="0" style="display:block; max-width:18px;" /></a></td>
                                        <td height="18" style="font-size:0px; line-height:0px;">&nbsp;</td>
                                        <td width="18" align="center" valign="middle" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="<?php echo $twitter; ?>" width="18" alt="tw" border="0" style="display:block; max-width:18px;" /></a></td>
                                        <td height="18" style="font-size:0px; line-height:0px;">&nbsp;</td>
                                        <td width="18" align="center" valign="middle" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="<?php echo $you; ?>" width="18" alt="yt" border="0" style="display:block; max-width:18px;" /></a></td>
                                        <td height="18" style="font-size:0px; line-height:0px;">&nbsp;</td>
                                        <td width="18" align="center" valign="middle" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="<?php echo $gplus; ?>" width="18" alt="g+" border="0" style="display:block; max-width:18px;" /></a></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>


@endsection


