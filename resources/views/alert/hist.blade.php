@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => 'Trackings'])


@if (request()->get('d') > 0 && request()->get('m') > 0)
<a class="btn btn-sm btn-outline-info" href="{{ route('alert.hist') }}">back</a><br><br>

<form method="POST" name="form_delAll" action="{{ route('alert.massDestroy') }}">

    <table class="table table-striped table-sm">

        <tr>
            <th colspan="3">
                <input type="checkbox" class="" value="1" id="checkAll" name="checkAll">
                select all
            </th>
            <th colspan="6"></th>
        </tr>

        @forelse ($alerts as $alert)
        <tr>
            <td><input type="checkbox" value="{{ $alert->id }}" name="ids[]"></td>
            <td>{{ $alert->id }}</td>
            <td>{{ $alert->device->name ?? '' }}</td>
            <td>{{ $alert->fence->name ?? '' }}</td>
            <td>{{ $alert->dt->format('l d/M H:i:s') }}</td>
            <td class="">
                <a class="btn btn-sm btn-outline-info" data-lat="{{ $alert->lat }}" data-lng="{{ $alert->lng }}"
                    data-cerca="{{ $alert->fence->fence ?? false }}" data-toggle="modal" data-target="#modal">detail</a>
            </td>
        </tr>

        @if ($loop->last)
        <tr>
            <td colspan="2">
                <button class="btn btn-sm btn-outline-danger">del selected</button>
            </td>
            <td colspan="7">

            </td>
        </tr>
        @endif

        @empty
        <p><b>No records</b></p>
        @endforelse
    </table>
</form>

@else
<div class="row">
    <div class="col-md-6">
        @include('shared.header', ['name' => 'Grouped By Device'])

        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th>device</th>
            </tr>
            @forelse ($device_days as $day)
            <tr>
                <td>{{ $day->tot }}</td>
                <td><a
                        href="{{ route('alert.hist',['d'=>$day->d,'m'=>$day->m,'device_id'=>$day->device_id ]) }}">{{ $day->d }}/{{ $day->m }}</a>
                </td>
                <td>{{ $day->device->name }}</td>
            </tr>
            @empty
            <p><b>No records</b></p>
            @endforelse
        </table>

    </div>
    <div class="col-md-6">
        @include('shared.header', ['name' => 'Grouped By Fence'])

        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th>fence</th>
            </tr>
            @forelse ($fence_days as $day)
            <tr>
                <td>{{ $day->tot }}</td>
                <td><a
                        href="{{ route('alert.hist',['d'=>$day->d,'m'=>$day->m,'fence_id'=>$day->fence_id ]) }}">{{ $day->d }}/{{ $day->m }}</a>
                </td>
                <td>{{ $day->fence->name }}</td>
            </tr>
            @empty
            <p><b>No records</b></p>
            @endforelse
        </table>

    </div>
</div>

@endif





<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_modal" class="mb-2" style="width:98%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')

<script src="https://maps.googleapis.com/maps/api/js?key={{env('API_GOOGLE')}}&libraries=visualization" async
    defer></script>

<script>

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });




    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var lat, lng;

        var modal = $(this)
        modal.find('.modal-title').text('Tracking Details');
        @if (isset($alerts[0]) && isset($alerts[0] -> lat))

            lat = parseFloat("{{ $alerts[0]->lat }}");
        lng = parseFloat("{{ $alerts[0]->lng }}");

        var map_modal = new google.maps.Map(document.getElementById('map_modal'), {
            center: { lat: lat, lng: lng },
            zoom: 13,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });

        var path = [];
        var marker, contentString;
        //var infowindow = new google.maps.InfoWindow();
        @forelse($alerts as $k=> $alert)


        lat = parseFloat("{{ $alert->lat }}");
        lng = parseFloat("{{ $alert->lng }}");
        marker = new google.maps.Marker({
            map: map_modal,
            label: "{{ $loop->iteration }}",
            position: { lat: lat, lng: lng }
        });


        google.maps.event.addListener(marker, "click", function () {
            //new google.maps.InfoWindow({ content: "{{ $loop->iteration }}" }).open(map, marker);
            new google.maps.InfoWindow({ content: "{{ $alert->dt->format('l d/M H:i:s') }}" }).open(map, marker);
        });



        path.push({ lat: parseFloat("{{ $alert->lat }}"), lng: parseFloat("{{ $alert->lng }}") });

        @empty
        alert('No alerts');
        @endforelse


        var pl = new google.maps.Polyline({
            path: path,
            geodesic: true,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#0000FF",
            fillOpacity: 0.1
        });
        pl.setMap(map_modal);

        @endif

    });



</script>

@endsection
