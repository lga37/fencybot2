@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => __('Trackings') ])


@if (request()->get('d') > 0 && request()->get('m') > 0)
<a class="btn btn-sm btn-outline-info" href="{{ route('alert.hist') }}">back</a><br><br>

<div id="map" class="mb-2" style="width:98%;height:600px;"></div>

@foreach ($fences as $fence)
<span class="tem_cerca" data-cercanome="{{$fence['name']}}" data-cerca="{{$fence['fence']}}"></span>

@endforeach


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
                    data-cerca="{{ $alert->fence->fence ?? false }}"
                    data-nome_cerca="{{ $alert->fence->name ?? false }}"
                    data-toggle="modal" data-target="#modal">detail</a>
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
        @include('shared.header', ['name' => __('Grouped By Device') ])

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
        @include('shared.header', ['name' => __('Grouped By Fence') ])

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

<script>

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });




    function show() {
        var lat, lng;
        @if (isset($alerts[0]) && isset($alerts[0] -> lat))

            lat = parseFloat({{ $alerts[0]-> lat }}) || -22.90278;
    lng = parseFloat({{ $alerts[0]-> lng }}) || -43.2075;


    var map_modal = new google.maps.Map(document.getElementById('map'), {
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
    @php $pula = false; @endphp
    @foreach($alerts as $alert)


    lat = parseFloat("{{ $alert->lat }}");
    lng = parseFloat("{{ $alert->lng }}");
    marker = new google.maps.Marker({
        map: map_modal,

                @if ($alert -> type == 0)
        icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
                @elseif($alert -> type == 1)
    icon: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
                @elseif($alert -> type == 2)
    icon: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                @elseif($alert -> type == 5)
    icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                @endif

    label: "{{ $loop->iteration }}",
        position: { lat: lat, lng: lng }
            });


    google.maps.event.addListener(marker, "click", function () {
        //new google.maps.InfoWindow({ content: "{{ $loop->iteration }}" }).open(map, marker);
        new google.maps.InfoWindow({ content: "{{ $alert->dt->format('l d/M H:i:s') }}" }).open(map, marker);
    });


    @if ($pula == false)
        path.push({ lat: parseFloat("{{ $alert->lat }}"), lng: parseFloat("{{ $alert->lng }}") });

    @endif


    @if ($alert -> type == 5)
        @php $pula = true; @endphp
    @else
    @php $pula = false; @endphp
    @endif


    @endforeach


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


    $('.tem_cerca').each(function (v) {
        //console.log(v);
        //console.log($(this).data('cerca'));
        //alert($(this).data('cerca').value);

        var coords = $(this).data('cerca');


        var cerca = new google.maps.Polygon({
            path: coords,
            strokeColor: "#000000",
            strokeOpacity: 0.9,
            strokeWeight: 2,
            fillColor: "#000000",
            fillOpacity: 0.3
        });

        cerca.setMap(map_modal);


    });




    @endif

    }










    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var modal = $(this)
        modal.find('.modal-title').text('Tracking Details');

        var lat = parseFloat(button.data('lat')) || -22.90278;
        var lng = parseFloat(button.data('lng')) || -43.2075;
        var cerca = button.data('cerca') || false;
        var nome_cerca = button.data('nome_cerca') || false;



        var map_modal = new google.maps.Map(document.getElementById('map_modal'), {
            center: { lat: lat, lng: lng },
            zoom: 13,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });

        const marker = new google.maps.Marker({
            map: map_modal,
            position: { lat: lat, lng: lng }
        });


        if (cerca) {

            //alert(cerca);

            var div = document.createElement('div');
            var h3 = document.createElement('h3');

            h3.innerHTML = 'Fence Related : ' + nome_cerca + ' ';
            div.appendChild(h3);

            map_modal.controls[google.maps.ControlPosition.RIGHT_TOP].push(div);



            var fence = new GMapFence();
            for (let i = 0; i < cerca.length; i++) {
                fence.addVertex(cerca[i]);
            }

            console.log(fence.generatePath());

            if (fence.isValid()) {
                var pl = new google.maps.Polygon({
                    path: fence.generatePath(),
                    //path: fence.generatePath(),
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.9,
                    strokeWeight: 3,
                    fillColor: "#0000FF",
                    fillOpacity: 0.3
                });
                pl.setMap(map_modal);

            } else {
                alert('cerca invalida');
            }



            $('.tem_cerca').each(function (v) {
                var coords = $(this).data('cerca');
                var cerca = new google.maps.Polygon({
                    path: coords,
                    strokeColor: "#000000",
                    strokeOpacity: 0.9,
                    strokeWeight: 2,
                    fillColor: "#000000",
                    fillOpacity: 0.3
                });

                cerca.setMap(map_modal);

            });

        }


        });






</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{env('API_GOOGLE')}}&callback=show"></script>

@endsection
