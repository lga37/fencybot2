@extends('layouts.adm')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<h1>Alertas </h1>
<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>ts</th>
        <th>type</th>
        <th>dt</th>
        <th>lat/lng</th>
        <th>lat/lng</th>
        <th>dist</th>
        <th>device</th>
        <th>cerca</th>
        <th>map</th>
        <th>del</th>
    </tr>
    @forelse ($alerts as $alert)
    <tr>
        <td>{{ $alert->id }}</td>
        <td>{{ $alert->created_at }}</td>
        <td>{{ $alert->type }}</td>
        <td>{{ $alert->dt }}</td>
        <td>{{ $alert->lat }} {{ $alert->lng }} </td>
        <td>{{ $alert->lat_fence }} {{ $alert->lng_fence }} </td>
        <td>{{ $alert->dist }}</td>

        <td>{{ $alert->device->name ?? '' }}</td>
        <td>{{ $alert->fence->name ?? '' }}</td>

        <td class="px-4 py-4">
            <button class="btn btn-primary" data-lat="{{ $alert->lat }}" data-lng="{{ $alert->lng }}"
                data-cerca="{{ $alert->fence->fence ?? false }}" data-toggle="modal" data-target="#modal">map</button>
        </td>
        <td class="px-4 py-4">
            <form method="POST" action="{{ route('alert.destroy',['alert'=>$alert]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger">del</button>
            </form>
        </td>
    </tr>


    @empty


    @endforelse
</table>

<hr>

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
                <div id="map" class="mb-2" style="width:98%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>



@endsection


@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('API_GOOGLE') }}&callback=init" async defer></script>
<script>

    function init() {

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var lat = parseFloat(button.data('lat')) || -22.90278;
            var lng = parseFloat(button.data('lng')) || -43.2075;
            var cerca = button.data('cerca') || false;
            var modal = $(this)
            modal.find('.modal-title').text(' Detalhamento:' + lat + ' / ' + lng)
            //modal.find('.modal-body input').val(recipient)

            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: lat, lng: lng },
                zoom: 15,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false

            });
            const marker = new google.maps.Marker({
                map: map,
                position: { lat: lat, lng: lng }
            });
            //alert(cerca);
            if (cerca) {
                var fence = new GMapFence();
                for (let i = 0; i < cerca.length; i++) {
                    fence.addVertex(cerca[i]);
                }

                if (fence.isValid()) {
                    /*                 var bounds = new google.maps.LatLngBounds(
                                        marker1.getPosition(), marker2.getPosition()
                                        fence.getBounds()
                                    );
                                    map.fitBounds(bounds); */
                    var pl = new google.maps.Polygon({
                        path: fence.generatePath(),
                        strokeColor: "#0000FF",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#0000FF",
                        fillOpacity: 0.1
                    });
                    pl.setMap(map);

                } else {
                    alert('cerca invalida');
                }
            }

        });


    }



</script>




@endsection
