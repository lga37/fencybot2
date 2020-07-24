@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => __('Invasions')])


<table class="table table-striped table-sm">
    <tr>
        <th>id</th>
        <th>{{ __('device') }}</th>
        <th>{{ __('time') }}</th>
        <th>{{ __('phone') }}</th>
        <th>{{ __('map') }}</th>
        <th>{{ __('del') }}</th>

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
                data-toggle="modal" data-target="#modal">{{ __('map') }}</button>
        </td>
        <td class="">
            <form method="POST" action="{{ route('alert.destroy',['alert'=>$alert]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-sm btn-danger">{{ __('del') }}</button>
            </form>
        </td>
    </tr>


    @empty
    <p><b>{{ __('No records')}}</b></p>


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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close*')}}</button>
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
        modal.find('.modal-title').text("{{ __('Tracking Details')}}" +' :'+ lat + ' / ' + lng)

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
