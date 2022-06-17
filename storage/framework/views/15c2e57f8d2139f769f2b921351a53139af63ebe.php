<?php $__env->startSection('content'); ?>

<div class="jumbotron">
    <h1 class="display-4">FencyBot - RealTime Monitoring</h1>
    <p class="lead">More than monitore, but also tracking.</p>
    <hr class="my-0">
    <img src="https://webengage.com/blog/wp-content/uploads/sites/4/2017/09/push-notifications.gif"
    alt="">

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script>
    function init() {
        var randLatLng = function () {
            return new google.maps.LatLng(((Math.random() * 17000 - 8500) / 100), ((Math.random() * 36000 - 18000) / 100));
        },
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: { lat: 0, lng: 0 }
            }),
            markers = [],
            markerCluster;
        for (var i = 0; i < 100; i++) {
            (function () {
                var marker = new google.maps.Marker({
                    position: randLatLng()
                }),
                    circle = new google.maps.Circle({
                        radius: 30.48,
                        fillColor: '#FACC2E',
                        strokeColor: '#000000',
                        strokeOpacity: 0.75
                        //,strokeWeight: 20
                    });
                circle.bindTo('center', marker, 'position');
                circle.bindTo('map', marker, 'map');
                markers.push(marker);
            })();
        }
        markerCluster = new MarkerClusterer(map, markers, {
            imagePath: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m'
        });

    }




</script>

<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>