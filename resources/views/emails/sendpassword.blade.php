@component('mail::message')
#Password for manual login

Thanks for creating an account with Dealsenroute.
your dummy password for manual login is {{ $password }} .

Thanks,<br>
{{ config('app.name') }}
@endcomponent
