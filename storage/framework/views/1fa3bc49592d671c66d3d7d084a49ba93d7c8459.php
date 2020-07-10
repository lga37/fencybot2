<?php $__env->startSection('css'); ?>
<style>
    .vitrine:hover {
        border: 1px solid blue;
    }


    #mapa {
        width: 100%;
        height: 500px;
    }

    #linklist {
        list-style-type: none;
        background: white;
        margin: 0;
        padding: 5px;
    }

    #linklist li {
        padding: 3px 10px;
    }

    #linklist li:hover {
        background: #dddddd;
    }

    #context_menu {
        position: absolute;
        display: none;
        visibility: hidden;
        background: white;
        border: 1px solid black;
        z-index: 10;
        cursor: context-menu;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Fences'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<form>
    <div class="form-group">
        Adding New Fences
    </div>
    <div class="form-group">
        <input class="form-control" id="pac-input" class="pac-target-input" placeholder="Enter a Location"
            autocomplete="off">
    </div>
    <div id="mapa" class="border border-danger"></div>

</form>

<br>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <input type="hidden" id="user_id" value="<?php echo e(Auth()->id()); ?>">
        <div class="row">
            <div class="col-md-3">
                <input class="form-control-lg  border border-success" id="nome_cerca" placeholder="Fence Name">
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <button class="btn  btn-block btn-lg btn-outline-warning " id="limpar">Clean Fence</button>
            </div>
            <div class="col-md-3">
                <button class="btn  btn-block btn-lg btn-outline-success" id="salvar">Save</button>
            </div>
        </div>
    </div>
</div>

<br>
<?php echo $__env->make('shared.header', ['name' => 'Edit your Fences'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php $__empty_1 = true; $__currentLoopData = $fences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php if($loop->first): ?>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <?php endif; ?>
        <div class="col-auto mb-3">
            <div class="card p-1 vitrine" style="width: 20rem;">
                <form method="POST" action="<?php echo e(route('fence.update',['fence'=>$fence->id])); ?>">

                    <div class="input-group mt-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                                title="Name of this fence"><span data-feather="map-pin"></span></div>
                        </div>
                        <input class="form-control" name="name" value="<?php echo e($fence->name); ?>">


                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-success">Save</button>
                        </div>

                    </div>
                </form>

                <div class="card-body">

                    <?php $tot=0; ?>
                    <?php $__empty_2 = true; $__currentLoopData = $fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fencedevice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <?php if($fence->id == $fencedevice->fence_id): ?>
                    <?php $tot++; ?>

                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <?php endif; ?>
                    <?php if($tot > 0): ?>
                    <?php echo e($tot); ?> device(s) associated
                    <?php else: ?>
                    Not associated yet
                    <?php endif; ?>



                </div>
                <div class="card-footer">

                    <form method="POST" action="<?php echo e(route('fence.destroy',['fence'=>$fence])); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>

                        <a href="<?php echo e(route('device.index')); ?>" class="btn mr-2 btn-sm btn-info">
                            configure
                        </a>
                        <a href="#" class="mr-2 btn btn-sm btn-primary" data-cerca="<?php echo e($fence->fence ?? false); ?>"
                            data-name="<?php echo e($fence->name); ?>" data-toggle="modal" data-target="#cerca_modal">
                            view
                        </a>
                        <button class="btn btn-sm btn-danger mr-2">del</button>
                    </form>

                </div>
            </div>
        </div>


        <?php if($loop->last): ?>
    </div>
</div>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<p><b>No records</b></p>

<?php endif; ?>
<br>



<div id="context_menu">
    <ul id="linklist">
        <li id="delete_mark">Delete</li>
        <li id="center_mark">Centralize Map</li>
        <li id="close_menu">Close</li>
    </ul>
</div>

<div class="modal fade" id="cerca_modal" tabindex="-1" role="dialog" aria-labelledby="cerca_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_cerca">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_cerca" class="mb-2" style="width:99%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&libraries=places&callback=init" async
    defer></script>
<script>

    $('#cerca_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var cerca = button.data('cerca');
        var label_cerca = button.data('name');
        $("#label_cerca").text(label_cerca);

        //console.log(cerca);

        var fence = new GMapFence();
        for (let i = 0; i < cerca.length; i++) {
            fence.addVertex(new GeoPoint(parseFloat(cerca[i].lat), parseFloat(cerca[i].lng)));
        }

        var centralPoint = fence.centralPointLatLng();
        //console.log(centralPoint);
        var center = fence.isValid() ? { 'lat': centralPoint._lat, 'lng': centralPoint._lon } : cerca[0];
        //console.log(center);

        var map = new google.maps.Map(document.getElementById('map_cerca'), {
            center: center,
            zoom: 17,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });

        var pl = new google.maps.Polygon({
            path: cerca,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#0000FF",
            fillOpacity: 0.1
        });

        pl.setMap(map);


    });

    function init() {
        $('form').on('keyup keypress', function (e) { //desabilitar os enters
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        let lat = -22.90278;
        let lng = -43.2075;
        fence = new GMapFence();

        if (typeof coords !== "undefined" && coords != null)
            for (i in coords)
                fence.addVertex(new GeoPoint(coords[i].lat, coords[i].lng));

        if (fence.numberOfVertices() > 0) {
            let p = fence.centralPointLatLng();
            lat = p.lat;
            lng = p.lng;
        }

        ctxMenu = new ContextMenu("#context_menu",
            [{ id: '#delete_mark', callback: deleteMark },
            { id: '#center_mark', callback: centerMark },
            { id: '#close_menu', callback: closeContextMenu }]);

        $("#salvar").on("click", saveFence);
        $("#limpar").on("click", cleanFence);

        let mapProp = {
            center: new google.maps.LatLng(lat, lng),
            draggableCursor: 'crosshair',
            zoom: 15,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: true,
            rotateControl: false
        }

        map = new google.maps.Map(document.getElementById('mapa'), mapProp)
        map.addListener('click', clickMap);
        drawFence();

        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            animation: google.maps.Animation.BOUNCE,
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
        });

        autocomplete.addListener('place_changed', function () {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/fence/index.blade.php ENDPATH**/ ?>