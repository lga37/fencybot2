<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplicativo de cerca eletronica">
    <meta name="author" content="Luis Gustavo Almeida">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>ADM</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        body {
            font-size: .875rem;
        }

        .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            /* Behind the navbar */
            padding: 48px 0 0;
            /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }

        @supports ((position: -webkit-sticky) or (position: sticky)) {
            .sidebar-sticky {
                position: -webkit-sticky;
                position: sticky;
            }
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #999;
        }

        .sidebar .nav-link.active {
            color: #007bff;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
            color: inherit;
        }

        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
        }

        /* Navbar */

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .navbar-toggler {
            top: .25rem;
            right: 1rem;
        }

        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }

        .form-control-dark {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }
    </style>
    <?php echo $__env->yieldContent('css'); ?>




    <script>
        window.Laravel = <?php echo json_encode([
            'csrf'=> csrf_token(),
            'pusher'=> [
                'key'=> config('broadcasting.connections.pusher.key'),
                'cluster'=> config('broadcasting.connections.pusher.options.cluster'),
            ],
            'user'=> auth() -> check() ? auth() -> user() -> id : '',
        ]); ?>

    </script>


    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" style="color:#0decf2" href="#">FencyBot</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="pr-5" style="color:#51b4e1">
            RealTime Monitoring People Tracking
        </span>
        <!--         <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <button class="btn-outline-danger p-2 rounded-lg text-nowrap mr-2">Sign Out</button>
        </form>
 -->

    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                            <a class="nav-link
                            <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                                <span data-feather="home"></span>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('type.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('type.index')); ?>">
                                <span data-feather="map-pin"></span>
                                TypesXXX
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('place.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('place.index')); ?>">
                                <span data-feather="map-pin"></span>
                                PlacesXXX
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('fence.*') ? 'active' : ''); ?>" href="<?php echo e(route('fence.index')); ?>">
                                <span data-feather="map-pin"></span>
                                Fences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('device.*') ? 'active' : ''); ?>" href="<?php echo e(route('device.index')); ?>">
                                <span data-feather="target"></span>
                                Devices
                            </a>
                        </li>
                        <li class="nav-item
                         d-flex justify-content-between align-items-center pr-4">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('alert.index') ? 'active' : ''); ?>" href="<?php echo e(route('alert.index')); ?>">
                                <span data-feather="bell"></span>
                                Alerts
                            </a>
<!--                             <span class="badge badge-pill badge-primary">1</span>
 -->                        </li>



                        <li class="nav-item
                         d-flex justify-content-between align-items-center pr-4">
                            <a class="nav-link
                                <?php echo e(request()->routeIs('alert.hist') ? 'active' : ''); ?>"
                                href="<?php echo e(route('alert.hist')); ?>">
                                <span data-feather="check"></span>
                                Trackings
                            </a>
                        </li>
                        <li class="nav-item
                         d-flex justify-content-between align-items-center pr-4">
                            <a class="nav-link
                                <?php echo e(request()->routeIs('alert.invasions') ? 'active' : ''); ?>"
                                href="<?php echo e(route('alert.invasions')); ?>">
                                <span data-feather="users"></span>
                                Invasions
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between
                        align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Admin & Configs</span>
                        <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                            <span data-feather="settings"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('user.profile') ? 'active' : ''); ?>"
                                href="<?php echo e(route('user.profile')); ?>">
                                <span data-feather="user"></span>
                                Profile
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link
                            <?php echo e(request()->routeIs('user.changepass') ? 'active' : ''); ?>"
                                href="<?php echo e(route('user.changepass')); ?>">
                                <span data-feather="unlock"></span>
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">

                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <button class="btn btn-link text-dark">
                                    <span data-feather="log-out"></span>
                                    <b>Logout</b>
                                </button>
                            </form>


                        </li>



                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>

    </div>


    <br><br>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <!--     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
 -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script src="<?php echo e(asset('js/cerca/html2canvas.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cerca/dms.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cerca/vector3d.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cerca/latlon-ellipsoidal.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cerca/utm.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cerca/scriptGMap.js')); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>


    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        /* globals Chart:false, feather:false */
        (function () {
            'use strict'

            feather.replace(); // icones

        }());




    </script>
    <?php echo $__env->yieldContent('js'); ?>
</body>

</html>
<?php /**PATH /var/www/fencybot/resources/views/layouts/adm.blade.php ENDPATH**/ ?>