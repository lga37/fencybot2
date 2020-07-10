<?php

echo "<pre>";

#echo env('API_GOOGLE');

########### rio
$lat = -22.973431;
$lng = -43.189621;



$lat = -23.631508562500;
$lng = -46.698816468750;


$lat = -22.920680000000;
$lng = -43.231937333333;

$r = 20;

$apikey = "AIzaSyBFH_SHIIC98-gnJxgLPDT11cbGqmGgeYk";

$required['key']=$apikey;
$required['location']=$lat.','.$lng;
$required['radius']=$r;
$required['sensor']='false';

$params['fields'] = 'name,place_id,types,vicinity';
$params['type'] = 'poi';

$api = 'https://maps.googleapis.com/maps/api/place/';
$recurso = 'nearbysearch';

$url = montaURL($api, $recurso, $required, $params);
#echo $url, "<br>";


$excluir = ['route','locality','political'];

$incluir = ['bakery','bank','bar','beauty_salon','cafe','igreja','convenience_store'
,'department_store','doctor','drugstore','gym','hair_care','hospital','pharmacy','police','restaurant','school','shopping_mall','store','
subway_station','supermarket'];

try {
    $res = file_get_contents($url);
    $j = json_decode($res,'true');
    #print_r($j);die;
    #print_r($j['results']);

    switch ($j['status']) {
        case 'OK':
            $c = array_column($j['results'],'name');
            #print_r($a);
            $a = array_column($j['results'],'types');
            #print_r($a);
            foreach($a as $k=>$v){
                #$b = array_intersect($incluir,$v);
                $b = array_intersect($excluir,$v);
                if(empty($b)){
                    print_r($b);
                    echo $j['results'][$k]['name'].' - ';
                    echo $j['results'][$k]['place_id'].' - ';
                    echo $j['results'][$k]['vicinity'].'<br>'; #pegar o lat/lng
                }
            }

        break;die;

        case 'ZERO_RESULTS':
        case 'OVER_QUERY_LIMIT':
        case 'REQUEST_DENIED':
        case 'INVALID_REQUEST':
        case 'UNKNOWN_ERROR':
        default:
            echo $res['status'];
            echo $res['error_message'] ?? 'erro -ccc';
            return false;
            break;
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
}


function montaURL(string $api, string $recurso, array $required, array $params = [], array $isolados = [], string $json = 'json')
{

    $req = http_build_query($required);
    $query = empty($params) ? '' : "&" . http_build_query($params);
    $unicos = empty($isolados) ? '' : "&" . implode("&", $isolados);


    $recurso_barra = empty($recurso) ? '' : $recurso . '/';

    $url = "$api$recurso_barra$json?$req$query$unicos";

    return trim($url);
}
