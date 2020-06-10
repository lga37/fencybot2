<?php $__env->startSection('content'); ?>


<div class="jumbotron">
    <h1 class="display-4">FencyBot - Monitore em tempo real</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to
        featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
</div>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
        </button>
    </div>
</div>

<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

<br><br>

<div id="map" class="border border-success" style="width: 99%; height: 400px;"></div>

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



    // ============================================================
    var ctx = document.getElementById('myChart');
    var d = {
        type: 'line',
        data: {
            labels: [
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday'
            ],
            datasets: [{
                data: [
                    15339,
                    21345,
                    18483,
                    24003,
                    23489,
                    24092,
                    12034
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    };
    var myChart = new Chart(ctx, d);

</script>

<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&libraries=drawing,places,geometry&callback=init"
    async defer></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/home.blade.php ENDPATH**/ ?>