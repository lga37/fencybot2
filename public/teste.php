<?php

echo "<pre>";

#echo env('API_GOOGLE');

########### rio
$lat = -22.973431;
$lng = -43.189621;

$lat = -23.636880;
$lng = -46.701880;

$lat = -23.633170;
$lng = -46.702260;



$r = 20;
#$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=" . env('API_GOOGLE') . "&location=42.3675294,-71.186966&radius=80";

#$res = file_get_contents($url);
$apikey = "AIzaSyBFH_SHIIC98-gnJxgLPDT11cbGqmGgeYk";

$required['key']=$apikey;
$required['location']=$lat.','.$lng;
$required['radius']=$r;
#$required['rankby']=$rankby; #prominence e default | se for = distance -> keyword, name or type required
$required['sensor']='false';

$params['fields'] = 'name,place_id,types,vicinity';
#$params['type'] = 'point_of_interest,drugstore,gym,hair_care';
$params['type'] = 'poi';

#print_r($res);

$api = 'https://maps.googleapis.com/maps/api/place/';
$recurso = 'nearbysearch';

$url = montaURL($api, $recurso, $required, $params);
#echo $url, "<br>";

#print_r($j['results']);

try {

    $res = file_get_contents($url);
    $j = json_decode($res,'true');

    switch ($j['status']) {
        case 'OK':
            $a = array_column($j['results'],'name');
            print_r($a);
            $a = array_column($j['results'],'types');
            print_r($a);

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






die;

function montaURL(string $api, string $recurso, array $required, array $params = [], array $isolados = [], string $json = 'json')
{

    $req = http_build_query($required);
    $query = empty($params) ? '' : "&" . http_build_query($params);
    $unicos = empty($isolados) ? '' : "&" . implode("&", $isolados);


    $recurso_barra = empty($recurso) ? '' : $recurso . '/';

    $url = "$api$recurso_barra$json?$req$query$unicos";

    return trim($url);
}

$regs = popula($api, $recurso, $required, $params);
$places = array_unique($regs);
print_r($places);


function popula($api, $recurso, $required, $params, $isolados = [], string $json = 'json')
{
    $url = montaURL($api, $recurso, $required, $params, $isolados, $json);
    #echo $url, "<br>";
    #die;
    $res = fetch2($url);

    print_r($res);
    #$places=[];
    $places = filtrarPlaces($res['results']);

    $next_page_token = array_key_exists('next_page_token', $res) ? $res['next_page_token'] : false;
    $i = 1;
    while ($next_page_token && $i <= 5) {
        $params['pagetoken'] = $next_page_token;
        $url = montaURL($api, $recurso, $required, $params);

        echo $url, '<br>';
        $res = fetch2($url);
        print_r($res);

        if (isset($res['results']) && !empty($res['results'])) {
            $places[] = filtrarPlaces($res['results']);
            $next_page_token = array_key_exists('next_page_token', $res) ? $res['next_page_token'] : false;
        } else {
            $next_page_token = false;
        }
        $i++;
    }

    return $places;
}

function filtrarPlaces(array $res, $seletivo = false)
{
    $places = [];

    foreach ($res as $k => $v) {
        if (!$seletivo || (isset($v['rating']) && $v['rating'] > 1 && isset($v['user_ratings_total']) && $v['user_ratings_total'] > 2)) {
            $places[] = $v['place_id'];
        }
    }
    return $places;
}






function getResults(string $url, $verb = 'GET')
{
    try {
        $res = fetch2($url, $verb);

        switch ($res['status']) {
            case 'OK':
                if (array_key_exists('next_page_token', $res)) {
                    $next_page_token = $res['next_page_token'];
                } else {
                    $next_page_token = false;
                }
                echo "<h1> $next_page_token</h1>";
                print_r($res);
                return ['res' => $res['results'], 'npt' => $next_page_token];
                #html_attributions
                break;

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
}



    /*
    The "status" field within the search response object contains the status of the request, and may contain debugging information to help you track down why the request failed. The "status" field may contain the following values:
    OK indicates that no errors occurred; the place was successfully detected and at least one result was returned.
    ZERO_RESULTS indicates that the search was successful but returned no results. This may occur if the search was passed a latlng in a remote location.
    OVER_QUERY_LIMIT indicates that you are over your quota.
    REQUEST_DENIED indicates that your request was denied, generally because of lack of an invalid key parameter.
    INVALID_REQUEST generally indicates that a required query parameter (location or radius) is missing.
    UNKNOWN_ERROR
    */
