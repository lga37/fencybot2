<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Trackings'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<form method="POST" action="<?php echo e(route('alert.filterTracks')); ?>">
    <div class="input-group mb-3">

        <input type="hidden" name="type" value="0">
        <select class="custom-select" name="device_id">
            <option selected disabled>Device</option>
            <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <option value="<?php echo e($device->id); ?>"><?php echo e($device->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
        </select>


        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt1</label>
        </div>
        <input class="form-control" type="date"
        value="<?php echo e(\Carbon\Carbon::parse(now()->subDays(7))->format('Y-m-d')); ?>" id="dt1" name="dt1">

        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt2</label>
        </div>
        <input class="form-control" type="date"
        value="<?php echo e(\Carbon\Carbon::parse(now())->format('Y-m-d')); ?>" id="dt2" name="dt2">

        <button class="btn btn-outline-secondary">Track</button>

    </div>
</form>

<br>

<table class="table table-striped table-sm">
    <tr>
        <th>id</th>
        <th>device</th>
        <th>time</th>
        <th>map</th>
        <th>del</th>
    </tr>
    <?php $i = 1; ?>
    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <?php if($loop->first): ?>
            <?php $davez = $alert->device_id; ?>
            <?php $exibe = true; ?>
        <?php else: ?>

            <?php $exibe = $alert->device_id != $davez; ?>
        <?php endif; ?>
        <?php $i = $exibe? 1: $i+1; ?>
        <?php if($exibe): ?>
        <tr>
            <td> <?php echo e($i); ?> - <?php echo e($alert->id); ?> </td>
            <td><?php echo e($alert->device->name ?? ''); ?></td>
            <td><?php echo e($alert->dt->format('l d/M H:i:s')); ?></td>
            <td class="">
                <button class="btn btn-primary" data-lat="<?php echo e($alert->lat); ?>" data-lng="<?php echo e($alert->lng); ?>"
                    data-cerca="<?php echo e($alert->fence->fence ?? false); ?>" data-toggle="modal"
                    data-target="#modal">track</button>
            </td>
            <td class="">
                <form method="POST" action="<?php echo e(route('alert.destroy',['alert'=>$alert])); ?>">
                    <?php echo method_field('DELETE'); ?>
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-danger">del</button>
                </form>
            </td>
        </tr>

        <?php else: ?>

        <?php endif; ?>
        <?php $davez = $alert->device_id; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p><b>No records</b></p>
    <?php endif; ?>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>

                            &libraries=visualization
                            &callback=init2"
    async defer></script>

<script>
    var map, heatmap;

    function init2() {
    }




    function init() {
        //return;

        alert(11)

        <?php if(isset($alerts[0]) && isset($alerts[0]->lat) ): ?>
            alert(22)
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                //center: { lat: 37.775, lng: -122.434 },
                center: { lat: parseFloat("<?php echo e($alerts[0]->lat); ?>"), lng: parseFloat("<?php echo e($alerts[0]->lat); ?>") },
                mapTypeId: 'terrain'
            });

            heatmap = new google.maps.visualization.HeatmapLayer({
                data: getPoints(),
                map: map
            });

        <?php endif; ?>

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
            <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                new google.maps.LatLng("<?php echo e($alert->lat); ?>", "<?php echo e($alert->lng); ?>"),
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
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


    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var lat,lng;

        var modal = $(this)
        modal.find('.modal-title').text('Tracking Details');
        <?php if(isset($alerts[0]) && isset($alerts[0]->lat) ): ?>

            lat = parseFloat("<?php echo e($alerts[0]->lat); ?>");
            lng = parseFloat("<?php echo e($alerts[0]->lng); ?>");

            var map_modal = new google.maps.Map(document.getElementById('map_modal'), {
                center: { lat: lat, lng: lng },
                zoom: 13,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false
            });

            var path = [];
            var marker, contentString, infowindow;
            <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                lat = parseFloat("<?php echo e($alert->lat); ?>");
                lng = parseFloat("<?php echo e($alert->lng); ?>");
                marker = new google.maps.Marker({
                    map: map_modal,
                    label:"<?php echo e($k); ?>",
                    position: { lat: lat, lng: lng }
                });

                contentString = "<?php echo e($alert->dt->format('l d/M H:i:s')); ?>";

                infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker.addListener('click', function() {
                    infowindow.open(map_modal, marker);
                });

                path.push({ lat: parseFloat("<?php echo e($alert->lat); ?>"), lng: parseFloat("<?php echo e($alert->lng); ?>")});

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>


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

        <?php endif; ?>

    });



</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/hist.blade.php ENDPATH**/ ?>