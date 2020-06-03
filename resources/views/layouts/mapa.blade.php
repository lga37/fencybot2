<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.18.0/css/mdb.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.18.0/js/mdb.min.js"></script>

    <!-- scripts de cálculos cartográficos -->
    <script src="{{ asset('js/cerca/dms.js') }}"></script>
    <script src="{{ asset('js/cerca/vector3d.js') }}"></script>
    <script src="{{ asset('js/cerca/latlon-ellipsoidal.js') }}"></script>
    <script src="{{ asset('js/cerca/utm.js') }}"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #mapa {
            width: 99%;
            height: 500px;
        }

        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 3px solid #000;
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


        .links>a {
            color: #636b6f;
            border: 1px solid blue;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
    <title>2222222222222</title>
</head>

<body>

    <!-- Conteúdo da página -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                @yield('content')
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <!-- Formulário para selecionar as opções -->
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-md-3" for="opcao">Opções:</label>
                        <div class="col-sm-8 col-md-9">
                            <input type="radio" name="opcao" value="1" id="op1" checked>
                            <label for="op1">Criar cerca</label><br>
                            <input type="radio" name="opcao" value="2" id="op2">
                            <label for="op2">Verificar se ponto pertence à cerca</label>
                        </div>
                    </div>
                </form>
                <hr>

                <!-- Formulário para criar a cerca -->
                <div id="form1">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3" for="lat">Cerca:</label>
                            <div class="col-sm-8 col-md-9">
                                <p class="form-control-static" id="vertices"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8 col-md-offset-3 col-md-9">
                                <button class="btn btn-default" id="mostrar">Coord cerca</button><br><br>
                                <button class="btn btn-default" id="limpar">Limpar cerca</button><br><br>
                                <button class="btn btn-default" id="salvar">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Formulário para verificar se um ponto pertence ou não à cerca -->
                <div id="form2">
                    <p>Clique no mapa p ver se o ponto está dentro/fora da cerca e/ou distante da borda</p>
                    <p>Defina abaixo a distância da borda, em metros:</p>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3" for="inside">Distância:</label>
                            <div class="col-sm-8 col-md-9">
                                <input type="number" min="0" style="width: 60px;" value="15" id="distance"> metros
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3" for="inside">Posição:</label>
                            <div class="col-sm-8 col-md-9">
                                <p class="form-control-static" id="inside"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3" for="distance">Distância da borda:</label>
                            <div class="col-sm-8 col-md-9">
                                <p class="form-control-static" id="border_distance"></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Área do mapa -->
            <div class="col-md-9 col-sm-9 p-5">
                <div id="mapa"></div>
            </div>
        </div>
    </div>

    <!-- Menu de contexto para os markers do mapa -->
    <div id="context_menu">
        <ul id="linklist">
            <li id="delete_mark">Deletar</li>
            <li id="center_mark">Centralizar</li>
            <li id="close_menu">Fechar</li>
        </ul>
    </div>

    <!-- Janela modal -->
    <div class="modal fade" id="janela_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo_modal">Modal Header</h4>
                </div>
                <div class="modal-body" id="texto_modal">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('API_GOOGLE') }}&callback=initApp" async
        defer></script>




</body>

</html>
