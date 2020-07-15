@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => __('Invasions')])

<!--
<form method="POST" action="{{ route('alert.filterTracks') }}">
    <div class="input-group mb-3">
        <input type="hidden" name="type" value="3">

        <select class="custom-select" name="device_id">
            <option selected disabled>Device</option>
            @forelse ($devices as $device)
            <option value="{{ $device->id }}">{{ $device->name }}</option>
            @empty

            @endforelse
        </select>


        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt1</label>
        </div>
        <input class="form-control" type="date"
        value="{{ \Carbon\Carbon::parse(now()->subDays(7))->format('Y-m-d') }}" id="dt1" name="dt1">

        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt2</label>
        </div>
        <input class="form-control" type="date"
        value="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}" id="dt2" name="dt2">

        <button class="btn btn-outline-secondary">Track</button>

    </div>
</form>
-->



<table class="table table-striped table-sm">
    <tr>
        <th>id</th>
        <th>device</th>
        <th>time</th>
        <th>phone</th>
        <th>map</th>
        <th>del</th>
    </tr>
    @forelse ($alerts as $alert)


    <tr>
        <td>{{ $alert->id }}</td>


            <td>{{ $alert->device->name ?? '' }}</td>
            <td>{{ $alert->dt->format('l d/M H:i:s') }}</td>

            <td>{{ $alert->phone ?? '-' }}</td>

        <td class="">
            <button class="btn btn-sm btn-primary" data-lat="{{ $alert->lat }}" data-lng="{{ $alert->lng }}"
                data-cerca="{{ $alert->fence->fence ?? false }}"
                data-toggle="modal" data-target="#modal">map</button>
        </td>
        <td class="">
            <form method="POST" action="{{ route('alert.destroy',['alert'=>$alert]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-sm btn-danger">del</button>
            </form>
        </td>
    </tr>


    @empty
    <p><b>No records</b></p>


    @endforelse
</table>


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
            </div>
        </div>
    </div>
</div>



@endsection


@section('js')

<script src="https://maps.googleapis.com/maps/api/js?key={{env('API_GOOGLE')}}&libraries=visualization"
    async defer></script>

<script>

    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var lat = parseFloat(button.data('lat')) || -22.90278;
        var lng = parseFloat(button.data('lng')) || -43.2075;
        //var cerca = button.data('cerca') || false;
        var modal = $(this)
        modal.find('.modal-title').text(' Details :' + lat + ' / ' + lng)

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

    });




</script>




@endsection
