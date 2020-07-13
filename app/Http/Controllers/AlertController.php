<?php

namespace App\Http\Controllers;

use App\Type;
use App\User;
use App\Alert;
use App\Fence;
use App\Place;
use App\Visit;
use Exception;
use App\Device;
use App\FenceDevice;
use Twilio\Rest\Client;

use App\Events\EventAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\AlertEmitted;
use Illuminate\Support\Facades\Auth;
use \App\Notifications\TelegramNotification;

class AlertController extends Controller
{

    public function parse(Request $request, int $device_id)
    {
        $alerts = Alert::select(DB::raw('max(id) AS `alert_id`,avg(lat) AS `lat`,avg(lng) AS `lng`,count(id) AS `tot`,round(dist) AS `dist`'))
            ->where('device_id', $device_id)
            ->where('dist', '>', 0)
            ->groupBy(DB::raw('round(dist)'))
            ->orderBy('tot', 'desc')->get()->toArray();

        #dd($alerts);
        $devices = Device::all();
        $types = Type::all();

        if ($alerts) {
            foreach ($alerts as $chave => $alert) {
                extract($alert);

                #dd($alert);
                $r = 20;
                $required['key'] = env('API_GOOGLE');
                $required['location'] = $lat . ',' . $lng;
                $required['radius'] = $r;
                $required['sensor'] = 'false';

                $params['fields'] = 'name,place_id,types,vicinity';
                $params['type'] = 'poi';

                $api = 'https://maps.googleapis.com/maps/api/place/';
                $recurso = 'nearbysearch';

                $url = $this->montaURL($api, $recurso, $required, $params);
                #echo $url, "<br>";


                $excluir = ['route', 'locality', 'political'];

                $incluir = [
                    'bakery', 'bank', 'bar', 'beauty_salon', 'cafe', 'igreja', 'convenience_store', 'department_store', 'doctor', 'drugstore', 'gym', 'hair_care', 'hospital', 'pharmacy', 'police', 'restaurant', 'school', 'shopping_mall', 'store', '
                subway_station', 'supermarket'
                ];

                try {
                    #echo "<pre>";
                    echo $chave . '<br>';
                    $res = file_get_contents($url);
                    #print_r($res);
                    $j = json_decode($res, 'true');
                    //print_r($j);
                    #print_r($j['results']);

                    switch ($j['status']) {
                        case 'OK':
                            $c = array_column($j['results'], 'name');
                            #print_r($a);
                            $a = array_column($j['results'], 'types');
                            #print_r($a);
                            foreach ($a as $k => $v) {
                                #$b = array_intersect($incluir,$v);
                                $b = array_intersect($excluir, $v);
                                if (empty($b)) {
                                    #print_r($j['results'][$k]);die;
                                    $name = $j['results'][$k]['name'];
                                    $place_key = $j['results'][$k]['place_id'];

                                    $lat = (float) $j['results'][$k]['geometry']['location']['lat'];
                                    $lng = (float) $j['results'][$k]['geometry']['location']['lng'];

                                    $address = $j['results'][$k]['vicinity']; #pegar o lat/lng
                                    $type_name = $j['results'][$k]['types'][0]; ### cuidado p nao por type

                                    echo $name, ' - ', $place_key, '- ', $lat, ',', $lng, '--', $address, '- ', $type_name;

                                    $type = new Type();
                                    #$type->name = $type;
                                    $type->updateOrCreate(['name' => $type_name]);

                                    $type_id = (int) Type::where('name', '=', $type_name)->first()->id;
                                    echo '<hr> type_id:' . $type_id;
                                    #die;

                                    $place = new Place();

                                    $place_upsert = compact('lat', 'lng', 'name', 'address', 'place_key', 'type_id');
                                    dump($place_upsert);
                                    $res = $place->insertOnDuplicateKey($place_upsert);
                                    var_dump($res);
                                    $place_id = (int) Place::where('place_key', '=', $place_key)->first()->id;

                                    echo '<hr> place_id:' . $place_id;
                                    #die;

                                    $visit = new Visit();
                                    $visit->place_id = $place_id;
                                    $visit->alert_id = $alert_id; #vem no max do groupBy
                                    $visit->save();
                                    echo '<hr> visit_id:' . $visit->id;


                                    Alert::where('device_id', '=', $device_id)->update(['parsed' => true]);
                                    die;
                                }
                            }

                            break;

                        case 'ZERO_RESULTS':
                        case 'OVER_QUERY_LIMIT':
                        case 'REQUEST_DENIED':
                        case 'INVALID_REQUEST':
                        case 'UNKNOWN_ERROR':
                        default:
                            echo "nada encontrado<br>";
                            break;
                    }
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                }
            }
        } else {
            echo "nada encontrado";
        }

        die;

        return view('type.index', compact('types', 'devices'));
    }

    private function montaURL(string $api, string $recurso, array $required, array $params = [], array $isolados = [], string $json = 'json')
    {

        $req = http_build_query($required);
        $query = empty($params) ? '' : "&" . http_build_query($params);
        $unicos = empty($isolados) ? '' : "&" . implode("&", $isolados);


        $recurso_barra = empty($recurso) ? '' : $recurso . '/';

        $url = "$api$recurso_barra$json?$req$query$unicos";

        return trim($url);
    }


    public function index(Request $request)
    {

        #dump($request->get('aa'));

        /*
        0 - dentro da cerca
        1 - usuário próximo à borda da cerca.
        2 - usuário fora da cerca.
        3 - invasão da cerca pessoal.
        4 - GPS desligado.
        5 - usuário volta para a cerca.
        Tipos 1, 2, 4 e 5 vem dist
 */

        $d = $request->get('d') ?? 0;
        $m = $request->get('m') ?? 0;
        $device_id = $request->get('device_id') ?? false;
        $fence_id = $request->get('fence_id') ?? false;
        #dd($d);

        if ($d > 0 && $m > 0) {
            $alerts = Alert::join('devices', function ($join) use ($device_id, $fence_id) {
                $join->on('alerts.device_id', '=', 'devices.id')
                    ->whereIn('alerts.type', [1, 2, 4, 5])
                    ->when($device_id, function ($q) use ($device_id) {
                        return $q->where('alerts.device_id', '=', (int) $device_id);
                    })

                    ->when($fence_id, function ($q) use ($fence_id) {
                        return $q->where('alerts.fence_id', '=', (int) $fence_id);
                    })
                    ->where('devices.user_id', '=', (int) Auth::id());
            })
            ->whereRaw ("day(dt)=$d AND month(dt)=$m ")
            ->with(['fence', 'device'])->orderBy('alerts.dt','asc')->select('alerts.*')->get();

            $fences = $alerts->pluck('fence')->unique();
            #dd($fences);

            $device_days = $fence_days = [];
        } else {

            $fence_days = Alert::join('fences', function ($join) {
                $join->on('alerts.fence_id', '=', 'fences.id')
                    ->whereIn('alerts.type', [1, 2, 4, 5])
                    ->where('fences.user_id', '=', (int) Auth::id());
            })
                ->groupBy(DB::raw('`fence_id`,month(dt),day(dt)'))
                ->orderBy('tot', 'desc')
                ->select(DB::raw('count(1) AS `tot`, fence_id, month(dt) AS `m`,day(dt) AS `d`'))
                ->with(['fence'])
                ->get();

            $device_days = Alert::join('devices', function ($join) {
                $join->on('alerts.device_id', '=', 'devices.id')
                    ->whereIn('alerts.type', [1, 2, 4, 5])
                    ->where('devices.user_id', '=', (int) Auth::id());
            })
                ->groupBy(DB::raw('`device_id`,month(dt),day(dt)'))
                ->orderBy('tot', 'desc')
                ->select(DB::raw('count(1) AS `tot`, device_id, month(dt) AS `m`,day(dt) AS `d`'))
                ->with(['device'])
                ->get();

            $alerts = $fences = [];
        }

        #echo "<hr>";
        #dd($alerts->toArray());
        #echo "<hr>";



        return view('alert.index', compact('fences','alerts', 'device_days', 'fence_days'));
    }

    public function hist(Request $request)
    {


        $d = $request->get('d') ?? 0;
        $m = $request->get('m') ?? 0;
        $device_id = $request->get('device_id') ?? false;
        $fence_id = $request->get('fence_id') ?? false;
        #dd($d);

        if ($d > 0 && $m > 0) {

            $alerts = Alert::join('devices', function ($join) use ($device_id, $fence_id) {
                $join->on('alerts.device_id', '=', 'devices.id')
                    ->where('devices.user_id', '=', (int) Auth::id())


                    ->when($device_id, function ($q) use ($device_id) {
                        return $q->where('alerts.device_id', '=', (int) $device_id);
                    })

                    ->when($fence_id, function ($q) use ($fence_id) {
                        return $q->where('alerts.fence_id', '=', (int) $fence_id);
                    })


                    ->whereIn('type', [0,1,2,5]);
            })
                ->select('alerts.id', 'alerts.type', 'alerts.dt', 'alerts.fence_id', 'alerts.device_id', 'alerts.lat', 'alerts.lng')->distinct()

                ->whereRaw("day(dt) = $d AND month(dt) = $m")
                ->orderBy('dt')
                ->get();

            $device_days = $fence_days = [];
        } else {

            $fence_days = Alert::join('fences', function ($join) {
                $join->on('alerts.fence_id', '=', 'fences.id')
                    ->where('alerts.type', '=', 0)
                    ->where('fences.user_id', '=', (int) Auth::id());
            })
                ->groupBy(DB::raw('`fence_id`,month(dt),day(dt)'))
                ->orderBy('tot', 'desc')
                ->select(DB::raw('count(1) AS `tot`, fence_id, month(dt) AS `m`,day(dt) AS `d`'))
                ->with(['fence'])
                ->get();

            $device_days = Alert::join('devices', function ($join) {
                $join->on('alerts.device_id', '=', 'devices.id')
                    ->where('alerts.type', '=', 0)
                    ->where('devices.user_id', '=', (int) Auth::id());
            })
                ->groupBy(DB::raw('`device_id`,month(dt),day(dt)'))
                ->orderBy('tot', 'desc')
                ->select(DB::raw('count(1) AS `tot`, device_id, month(dt) AS `m`,day(dt) AS `d`'))
                ->with(['device'])
                ->get();

            $alerts = [];
        }



        return view('alert.hist', compact('fence_days', 'device_days', 'alerts'));
    }

    public function invasions(Request $request)
    {
        $devices = Device::all();

        $alerts = Alert::join('devices', function ($join) {
            $join->on('alerts.device_id', '=', 'devices.id')
                ->where('devices.user_id', '=', (int) Auth::id());
        })
            ->where('type', 3)
            ->with(['device'])->select('alerts.*')
            ->orderBy('dt')->get();


        return view('alert.invasions', compact('devices', 'alerts'));
    }


    public function filter(Request $request)
    {
        $devices = Device::all();
        #$devices_ids = $devices->pluck('id');
        #dd($devices_ids);

        $fences = Fence::all();

        $fence_id = $request->post('fence_id');
        $device_id = $request->post('device_id');
        $type = $request->post('type');
        $dt1 = $request->post('dt1');
        $dt2 = $request->post('dt2');
        $order = $request->post('order');

        $alerts = Alert::join('devices', function ($join) {
            $join->on('alerts.device_id', '=', 'devices.id')
                ->where('devices.user_id', '=', (int) Auth::id());
        })
            ->whereIn('type', [0, 1, 2, 3])

            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($fence_id, function ($query, $fence_id) {
                return $query->where('fence_id', $fence_id);
            })
            ->when($device_id, function ($query, $device_id) {
                return $query->where('device_id', $device_id);
            })
            ->when($dt1, function ($query, $dt1) {
                return $query->where('dt', '>=', $dt1);
            })
            ->when($dt2, function ($query, $dt2) {
                return $query->where('dt', '<=', $dt2);
            })

            ->orderBy('dt', $order)


            ->with(['fence', 'device'])->get();

        #DB::table('users')->where('votes', '>', 100)->dd();
        # DB::table('users')->where('votes', '>', 100)->dump();

        return view('alert.index', compact('fences', 'devices', 'alerts'));
    }


    public function filterTracks(Request $request)
    {
        $devices = Device::all();

        $device_id = $request->post('device_id');
        $dt1 = $request->post('dt1');
        $dt2 = $request->post('dt2');


        $alerts = Alert::when($device_id, function ($query, $device_id) {
            return $query->where('device_id', $device_id);
        })

            ->when($dt1, function ($query, $dt1) {
                return $query->where('dt', '>=', $dt1);
            })
            ->when($dt2, function ($query, $dt2) {
                return $query->where('dt', '<=', $dt2);
            })

            ->orderBy('dt', 'asc')

            ->with(['fence', 'device'])->get();

        #DB::table('users')->where('votes', '>', 100)->dd();
        # DB::table('users')->where('votes', '>', 100)->dump();

        $tot = $alerts->count();
        $exibe = true;
        return view('alert.hist', compact('devices', 'alerts', 'device_id', 'exibe', 'tot'));
    }


    private function getDevicesByTel($tel)
    {
        $devices_id = Device::where('tel', $tel)->select('id', 'name', 'user_id')->get();

        #dd($devices_id);
        return $devices_id;
    }

    public function postAlerts(Request $request, string $tel)
    {

        $devices = $this->getDevicesByTel($tel);

        $lotes = $request->json();
        $errors = [];

        if ($devices->count() > 0) {
            $devices->each(function ($item, $key) use ($lotes, &$errors) {
                foreach ($lotes as $k => $v) {
                    #extract($v);

                    if (!$v['fence_id'] > 0) {
                        $errors[] = "fence_id is missing (indice $k)";
                        continue;
                    }
                    $exists = FenceDevice::where('fence_id', '=', $v['fence_id'])
                        ->where('device_id', '=', $item->id)
                        ->where('user_id', '=', $item->user_id)->exists();
                    #dd($exists);
                    #if(!$exists) continue;
                    if (!$exists) {
                        $errors[] = "device_id/user_id mismatch  (indice $k)";
                        continue;
                    }


                    $alert = new Alert();
                    $alert->device_id = (int) $item->id;

                    $alert->fence_id = $v['fence_id'];
                    $alert->lat = $v['lat'];
                    $alert->lng = $v['lng'];
                    $alert->lat_fence = $v['lat_fence'] ?? null;
                    $alert->lng_fence = $v['lng_fence'] ?? null;
                    $alert->dist = $v['dist'] ?? null;
                    $alert->type = $v['type'] ?? 0;
                    $alert->dt = $v['dt'] ?? null;
                    #dd($alert);
                    $res = $alert->save();
                    #dump($res);
                    $user_id = (int) $item->user_id;

                    $user = User::find($user_id);


                    if ($v['type'] == 2) {

                        $last_alert = Alert::where('type', '=', 2)
                            ->where('fence_id', '=', $v['fence_id'])
                            ->where('device_id', '=', $item->id)
                            ->latest()->select(DB::raw('id,day(created_at),day(dt), TIMESTAMPDIFF( MINUTE, created_at,now() ) AS diff'))
                            ->get()->toArray();
                        $last_minutes = $last_alert[0]['diff'] ?? 0;

                        if ($last_minutes > 120 && $v['fence_id'] > 0) {
                            $fence = Fence::find($v['fence_id']);
                            $fence_name = $fence->name;

                            $tel = $user->tel;
                            if (strlen($tel) == 11) {
                                $tel = '+55' . $tel;
                            } elseif (strlen($tel) == 13) {
                                $tel = '+' . $tel;
                            } else {
                                $errors[] = "tel nao 11,13 dig ($tel , indice $k)";
                                break;
                            }
                            $place = $this->geo($v['lat'], $v['lng']);
                            $mapa = "http://www.google.com/maps/place/{$v['lat']},{$v['lng']}";
                            $msg = " FencyBot Alert! ";
                            $msg .= " Hi " . $user->name;
                            $msg .= " The device " . $item->name . " is out of fence (" . $fence_name . ").";
                            if ($place) {
                                $msg .= " Place of Reference : $place";
                            }
                            $msg .= " Click To See on Map: $mapa ";
                            $msg .= "FencyBot Monitor";
                            #dd($msg);

                            $this->sendMessage($msg, $tel);
                        }
                    }


                    $last_alert = Alert::where('fence_id', '=', $v['fence_id'])
                    ->where('device_id', '=', $item->id)
                    ->latest()->select(DB::raw('id,day(created_at),day(dt), TIMESTAMPDIFF( MINUTE, created_at,now() ) AS diff'))
                    ->get()->toArray();
                    $last_minutes = $last_alert[0]['diff'] ?? 0;
                    if ($last_minutes > 120 && $v['fence_id'] > 0) {
                        $user->notify((new AlertEmitted($alert)));
                        //event(new EventAlert($alert));

                    }

                }

            });

        } else {
            #return response()->json(['status' => 'ERROR'], 406);
            $errors[] = 'nao encontrou devices para tel '.$tel;
        }


        if (empty($errors)) {
            return response()->json(['status' => 'OK'], 201);
        } else {
            return response()->json(['status' => 'ERROR', 'errors' => implode('; ',$errors)], 422);

        }
    }


    function geo($lat, $lng)
    {
        $geolocation = $lat . ',' . $lng;
        $u = "https://maps.googleapis.com/maps/api/geocode/json?key=" . env('API_GOOGLE') . "&latlng=$geolocation&sensor=false";

        $file_contents = file_get_contents($u);
        $json_decode = json_decode($file_contents);
        if (isset($json_decode->results[0])) {
            $response = [];
            foreach ($json_decode->results[0]->address_components as $addressComponet) {
                if (in_array('political', $addressComponet->types)) {
                    $response[] = $addressComponet->long_name;
                }
            }

            return  $response[0] ?? null;
        }
        return null;
    }


    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $recipients,
            ['from' => $twilio_number, 'body' => $message]
        );
    }



    public function track(Request $request, string $tel)
    {

        $devices = $this->getDevicesByTel($tel);
        $lotes = $request->json();
        #dd($lotes);
        if ($lotes->count() == 0) {
            return response()->json(['status' => 'ERROR - empty JSON'], 406);
        }
        if ($devices->count() > 0) {
            $devices->each(function ($item, $key) use ($lotes) {
                foreach ($lotes as $v) {
                    $alert = new Alert();
                    $alert->device_id = (int) $item->id;

                    $alert->fence_id = $v['fence_id'] ?? null;
                    $alert->lat = $v['lat'];
                    $alert->lng = $v['lng'];
                    $alert->dt = $v['dt'] ?? null;
                    $alert->save();

                    $user_id = (int) $item->user_id;
                    $user = User::find($user_id);
                    //$user->notify((new AlertEmitted($alert)));
                    //event(new EventAlert($alert));

                }
            });
        } else {
            return response()->json(['status' => 'ERRO'], 406);
        }
        return response()->json(['status' => 'OK'], 201);
    }




    public function invasion(Request $request, string $tel)
    {
        #dd('hhh');

        $devices = $this->getDevicesByTel($tel);
        $lotes = $request->json();
        #dd($lotes);
        if ($lotes->count() == 0) {
            return response()->json(['status' => 'ERROR - empty JSON'], 406);
        }
        if ($devices->count() > 0) {
            $devices->each(function ($item, $key) use ($lotes) {
                foreach ($lotes as $v) {
                    $alert = new Alert();
                    $alert->device_id = (int) $item->id;

                    $alert->type = 3;
                    $alert->phone = $v['phone'] ?? null;
                    $alert->lat = $v['lat'];
                    $alert->lng = $v['lng'];
                    $alert->dt = $v['dt'] ?? null;
                    $alert->save();

                    $user_id = (int) $item->user_id;
                    $user = User::find($user_id);
                    //$user->notify((new AlertEmitted($alert)));
                    //event(new EventAlert($alert));

                }
            });
        } else {
            return response()->json(['status' => 'ERRO'], 406);
        }
        return response()->json(['status' => 'OK'], 201);
    }







    public function destroy(Alert $alert)
    {

        $alert->delete();

        return back()->withSuccess('Record Deleted with Success');
    }


    private function isValid(Request $request)
    {

        $request->only(['fencedevice_id', 'lat', 'lng']);

        $request->validate([
            'fencedevice_id' => 'required|integer',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ], [
            #'name.required' => 'Nome e obrigatorio',
            #'name.min' => 'Minimo de 5 carcateres',
        ]);
        return $request;
    }


    public function massDestroy(Request $request)
    {

        #dd($request);
        #dd($request->post('ids'));

        $request->validate([
            'ids'   => 'bail|required|array',
            'ids.*' => 'exists:alerts,id',
        ]);

        $ids = $request->post('ids');
        Alert::whereIn('id', $ids)->delete();

        return back()->withSuccess('Record(s) Deleted with Success');
        #return redirect()->route('alert.hist')->withSuccess('Alerts deleted with success!');;
    }
}
