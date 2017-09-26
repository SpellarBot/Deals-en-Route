@component('mail::message')
# Verify Your Email

Thanks for creating an account with the verification in dealsenroute website.
Please click the button below to verify your email address


@component('mail::button', ['url' => URL::to('register/verify/' . $confirmation_code)])
Verify Your Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
<br>
<br>
<br>
If you’re having trouble clicking the "Reset Password" button, 
copy and paste the URL below into your 
web browser: {{ URL::to('register/verify/' . $confirmation_code) }}
@endcomponent


