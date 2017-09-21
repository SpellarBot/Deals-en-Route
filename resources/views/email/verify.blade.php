@component('vendor.mail.html.message')
<div class='container' text-align="center">
  

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with the verification in dealsenroute website.
            Please follow the link below to verify your email address
            {{ URL::to('register/verify/' . $confirmation_code) }}.<br/>

        </div>
       
    </td>
  </tr>
</table>

</div>