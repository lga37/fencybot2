
@component('mail::message')

You are receiving a FencyBot Alert;

<ul>
    <li>Time: {{ $alert->dt }}</li>
    <li>Device: {{ $alert->device->name }}</li>
    <li>Fence: {{ $alert->fence->name }}</li>
    <li>Link on Map: <a href="http://www.google.com/maps/place/{{ $alert->lat }},{{ $alert->lng }}">Check</a></li>
    <li>Lat: {{ $alert->lat }}</li>
    <li>Lng: {{ $alert->lng }}</li>

</ul>




Thanks,<br>
{{ config('app.name') }}
@endcomponent
