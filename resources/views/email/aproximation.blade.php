
@component('mail::message')

You are receiving a FencyBot Alert;<br>

The device {{ $name }} have been close to a contamined person.<br>

Number of approximation events: {{ $tot }}<br><br>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
