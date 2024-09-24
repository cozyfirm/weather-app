@component('mail::message')
# Kreiranje računa

Poštovani/a {{ $_name }},

Uspješno ste kreirali profil na www.talentakademija.com.

Za verifikaciju Vašeg email-a, molimo kliknite <a href="{{ route('auth.verify-account', ['token' => $_token]) }}">ovdje</a>.

Hvala Vam što koristite naš sistem!
Ugodan ostatak dana,<br>
<a href="{{ env('APP_DOMAIN') }}"> Helem Nejse Talent akademija </a>
@endcomponent
