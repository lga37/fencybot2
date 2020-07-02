@extends('layouts.adm')

@section('css')
<style>
    #wrap{
        position: relative;

    }
    #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }
</style>
@endsection


@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => 'Places'])



<br>

<table class="table table-striped table-sm">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>type</th>
        <th>num. visits</th>
        <th>del</th>
    </tr>


    </table>


<div id="wrap">
    <div id="floating-panel">
        <button onclick="toggleHeatmap()">Toggle Heatmap</button>
        <button onclick="changeGradient()">Change gradient</button>
        <button onclick="changeRadius()">Change radius</button>
        <button onclick="changeOpacity()">Change opacity</button>
    </div>
    <div id="map" class="border border-danger" style="width: 100%;height: 500px;"></div>
</div>


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

<script src="https://maps.googleapis.com/maps/api/js?key={{env('API_GOOGLE')}}&libraries=visualization&callback=init"
    async defer></script>

<script>
    var map, heatmap;

    function init() {
        //return;



        @if (isset($alerts[0]) && isset($alerts[0]->lat) )
            //alert(22)
            let lat = -22.90278;
            let lng = -43.2075;

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: { lat: lat, lng: lng },
                //center: { lat: parseFloat("{{ $alerts[0]->lat }}"), lng: parseFloat("{{ $alerts[0]->lat }}") },
                mapTypeId: 'terrain'
            });

            heatmap = new google.maps.visualization.HeatmapLayer({
                data: getPoints(),
                map: map
            });

        @endif

    }

    function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function changeGradient() {
        var gradient = [
            'rgba(0, 255, 255, 0)',
            'rgba(0, 255, 255, 1)',
            'rgba(0, 191, 255, 1)',
            'rgba(0, 127, 255, 1)',
            'rgba(0, 63, 255, 1)',
            'rgba(0, 0, 255, 1)',
            'rgba(0, 0, 223, 1)',
            'rgba(0, 0, 191, 1)',
            'rgba(0, 0, 159, 1)',
            'rgba(0, 0, 127, 1)',
            'rgba(63, 0, 91, 1)',
            'rgba(127, 0, 63, 1)',
            'rgba(191, 0, 31, 1)',
            'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
    }

    function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
    }

    function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
    }

    function getPoints() {

        var points = [
            @forelse ($alerts as $alert)
                new google.maps.LatLng("{{ $alert->lat }}", "{{ $alert->lng }}"),
            @empty
            @endforelse
        ];

        console.log(points);

        return points;

    }


    function geocodeLatLng(lat, lng) {
        var geocoder = new google.maps.Geocoder;
        var latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
            geocoder.geocode({ 'location': latlng }, function (results, status) {
            if (status == 'OK') {
                if (results[0]) {
                    alert(results[0].formatted_address);
                } else {
                    return 'No results found';
                }
            } else {
                return 'Geocoder failed due to: ' + status;
            }
        });
    }


</script>

@endsection
