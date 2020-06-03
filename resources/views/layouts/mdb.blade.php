<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MDB</title>
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('mdb/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">


    <style>
        html,
        body,
        header,
        .view {
            height: 100%;
        }

        @media (max-width: 740px) {

            html,
            body,
            header,
            .view {
                height: 1000px;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {

            html,
            body,
            header,
            .view {
                height: 650px;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {
            .navbar:not(.top-nav-collapse) {
                background: #1C2331 !important;
            }
        }

        /* Navbar animation */
        .navbar {
            background-color: rgba(0, 0, 0, 0.3);
        }

        .top-nav-collapse {
            background-color: #1C2331;
        }

        /* Adding color to the Navbar on mobile */
        @media only screen and (max-width: 768px) {
            .navbar {
                background-color: #1C2331;
            }
        }

        /* Footer color for sake of consistency with Navbar */
        .page-footer {
            background-color: #1C2331;
        }
    </style>
</head>

<body>


    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="https://mdbootstrap.com/docs/jquery/" target="_blank">
                <strong>MDB</strong>
            </a>

            <!-- Collapse -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://mdbootstrap.com/docs/jquery/" target="_blank">About MDB</a>
                    </li>
                </ul>

                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item">
                        <a href="https://www.facebook.com/mdbootstrap" class="nav-link" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://github.com/mdbootstrap/bootstrap-material-design"
                            class="nav-link border border-light rounded" target="_blank">
                            <i class="fab fa-github mr-2"></i>MDB GitHub
                        </a>
                    </li>
                </ul>

            </div>

        </div>
    </nav>
    <!-- Navbar -->

    <!-- Full Page Intro -->
    <div class="view full-page-intro"
        style="background-image: url(&apos;https://mdbootstrap.com/img/Photos/Others/images/78.jpg&apos;); background-repeat: no-repeat; background-size: cover;">

        <!-- Mask & flexbox options-->
        <div class="mask rgba-black-light d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="container">

                <!--Grid row-->
                <div class="row wow fadeIn">

                    <!--Grid column-->
                    <div class="col-md-6 mb-4 white-text text-center text-md-left">

                        <h1 class="display-4 font-weight-bold">Learn Bootstrap 4 with MDB</h1>

                        <hr class="hr-light">

                        <p>
                            <strong>Best &amp; free guide of responsive web design</strong>
                        </p>

                        <p class="mb-4 d-none d-md-block">
                            <strong>The most comprehensive tutorial for the Bootstrap 4. Loved by over 500 000 users.
                                Video and written versions
                                available. Create your own, stunning website.</strong>
                        </p>

                        <a target="_blank" href="https://mdbootstrap.com/education/bootstrap/"
                            class="btn btn-indigo btn-lg">Start free tutorial
                            <i class="fas fa-graduation-cap ml-2"></i>
                        </a>

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6 col-xl-5 mb-4">

                        <!--Card-->
                        <div class="card">

                            <!--Card content-->
                            <div class="card-body">

                                <!-- Form -->
                                <form name>
                                    <!-- Heading -->
                                    <h3 class="dark-grey-text text-center">
                                        <strong>Write to us:</strong>
                                    </h3>
                                    <hr>

                                    <div class="md-form">
                                        <i class="fas fa-user prefix grey-text"></i>
                                        <input type="text" id="form3" class="form-control">
                                        <label for="form3">Your name</label>
                                    </div>
                                    <div class="md-form">
                                        <i class="fas fa-envelope prefix grey-text"></i>
                                        <input type="text" id="form2" class="form-control">
                                        <label for="form2">Your email</label>
                                    </div>

                                    <div class="md-form">
                                        <i class="fas fa-pencil-alt prefix grey-text"></i>
                                        <textarea type="text" id="form8" class="md-textarea"></textarea>
                                        <label for="form8">Your message</label>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-indigo">Send</button>
                                        <hr>
                                        <fieldset class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox1">
                                            <label for="checkbox1" class="form-check-label dark-grey-text">Subscribe me
                                                to the newsletter</label>
                                        </fieldset>
                                    </div>

                                </form>
                                <!-- Form -->

                            </div>

                        </div>
                        <!--/.Card-->

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

            </div>
            <!-- Content -->

        </div>
        <!-- Mask & flexbox options-->

    </div>
    <!-- Full Page Intro -->

    <!--Main layout-->
    <main>
        <select class="select" multiple size=5>
            <option selected>Mustard</option>
            <option>Ketchup</option>
            <option>Relish</option>
            <option selected>Relish</option>
            <option>Relish</option>
        </select>


    </main>
    <!--Main layout-->

    <!--Footer-->
    <footer class="page-footer text-center font-small mt-4 wow fadeIn">

        <!--Call to action-->
        <div class="pt-4">
            <a class="btn btn-outline-white" href="https://mdbootstrap.com/docs/jquery/getting-started/download/"
                target="_blank" role="button">Download MDB
                <i class="fas fa-download ml-2"></i>
            </a>
            <a class="btn btn-outline-white" href="https://mdbootstrap.com/education/bootstrap/" target="_blank"
                role="button">Start free tutorial
                <i class="fas fa-graduation-cap ml-2"></i>
            </a>
        </div>
        <!--/.Call to action-->

        <hr class="my-4">




        <!-- Social icons -->
        <div class="pb-4">
            <a href="https://www.facebook.com/mdbootstrap" target="_blank">
                <i class="fab fa-facebook-f mr-3"></i>
            </a>

            <a href="https://twitter.com/MDBootstrap" target="_blank">
                <i class="fab fa-twitter mr-3"></i>
            </a>

            <a href="https://www.youtube.com/watch?v=7MUISDJ5ZZ4" target="_blank">
                <i class="fab fa-youtube mr-3"></i>
            </a>

            <a href="https://plus.google.com/u/0/b/107863090883699620484" target="_blank">
                <i class="fab fa-google-plus-g mr-3"></i>
            </a>

            <a href="https://dribbble.com/mdbootstrap" target="_blank">
                <i class="fab fa-dribbble mr-3"></i>
            </a>

            <a href="https://pinterest.com/mdbootstrap" target="_blank">
                <i class="fab fa-pinterest mr-3"></i>
            </a>

            <a href="https://github.com/mdbootstrap/bootstrap-material-design" target="_blank">
                <i class="fab fa-github mr-3"></i>
            </a>

            <a href="http://codepen.io/mdbootstrap/" target="_blank">
                <i class="fab fa-codepen mr-3"></i>
            </a>
        </div>
        <!-- Social icons -->

        <!--Copyright-->
        <div class="footer-copyright py-3">
            &#xA9; 2018 Copyright:
            <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->





    @yield('content')



    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/cerca/dms.js') }}"></script>
    <script src="{{ asset('js/cerca/vector3d.js') }}"></script>
    <script src="{{ asset('js/cerca/latlon-ellipsoidal.js') }}"></script>
    <script src="{{ asset('js/cerca/utm.js') }}"></script>
    <script src="{{ asset('js/cerca/scriptGMap.js') }}"></script>





    <script src="{{ asset('mdb/js/jquery.min.js') }}"></script>
    <script src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <script src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>




    @yield('javascript')

</body>

</html>
