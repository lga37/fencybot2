
@component('mail::message')

You are receiving a FencyBot Alert;

<ul>
    <li>Lat: {{ $alert->lat }}</li>
    <li>Lng: {{ $alert->lng }}</li>
    <li>Time: {{ $alert->dt }}</li>

</ul>




Thanks,<br>
{{ config('app.name') }}
@endcomponent
