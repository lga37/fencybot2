<?php

namespace App\Http\Controllers;

use App\User;
use App\Alert;
use App\Fence;
use App\Device;
use App\FenceDevice;
use Illuminate\Http\Request;
use \App\Notifications\TelegramNotification;

class AlertController extends Controller
{

    public function index(Request $request)
    {
        #dd($request);

        $devices = Device::with('fences')->get();
        #$devices = Device::all();
        $fencedevices = FenceDevice::all();

        #dd($devices);

        $alerts = Alert::all();

        $fences = Fence::paginate(6);
        return view('alert.index', compact('fences', 'devices', 'alerts', 'fencedevices'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->isValid($request);

        $alert = new Alert();
        $alert->fencedevice_id =  $request->get('fencedevice_id');
        $alert->lat = $request->get('lat');
        $alert->lng = $request->get('lng');

        $alert->save();



        #Auth::user()->notify(new TelegramNotification());
        User::find(1)->notify(new TelegramNotification());


        #bot Uniriofencebot
        #@Uniriofencebot
        #1205995416:AAGAdQjNMNCDsjWJVLzZavNdvwrkvqwn8H8
        #Uniriogrupofencebot

        #https://api.telegram.org/bot[BOT_API_KEY]/sendMessage?chat_id=[MY_CHANNEL_NAME]&text=[MY_MESSAGE_TEXT]

        /*
        $apiToken = "1205995416:AAGAdQjNMNCDsjWJVLzZavNdvwrkvqwn8H8";

        $res = file_get_contents("https://api.telegram.org/bot$apiToken/getMe");

        dd($res);

        curl https://api.telegram.org/bot1205995416:AAGAdQjNMNCDsjWJVLzZavNdvwrkvqwn8H8/getUpdates

        $res = file_get_contents("https://api.telegram.org/bot$apiToken/getUpdates");
        echo "<pre>";
        $res = json_decode($res,true);
        $chat_id = $res['result'][0]['message']['chat']['id'];

        #"" chat_id

        #dd($res["chat"]);




        $data = [
            'chat_id' => $chat_id,
            'latitude' => (float) $request->get('lat'),
            'longitude' => (float) $request->get('lng'),
        ];
        $params = http_build_query($data);

        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendLocation?$params");

        dd($response);



        $data = [
            'chat_id' => $chat_id,
            'text' => 'alerta de proximidade - cerca xxx, device yyy',
        ];
        $params = http_build_query($data);

        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?$params");

        dd($response);

*/

        return response()->json(['status' => 'OK'], 201);
    }

    public function show(int $id)
    {
        $alert = Alert::find($id);
        return view('alert.show', compact('alert'));
    }


    public function edit(Alert $alert)
    {
        //
    }

    public function postAlerts(Request $request, string $tel)
    {

        /*
        [ { "id":99, "type": 2, "lat":-22.921545, "lng":-43.232289,
            "dist": 15.3, "dt":26052020151345 },
          { "id":99, "type": 1, "lat":-22.921545, "lng":-43.232289,
            "dist": 0, "dt":26052020151357 } ]
*/
        foreach($request as $k=>$v){
            $alert = new Alert();
            $alert->fence_id = $v['id'];
            $alert->lat = $v['lat'];
            $alert->lng = $v['lng'];
            $alert->dist = $v['dist'];
            $alert->dt = $v['dt'];
            $alert->create();
        }
        return response()->json(['status' => 'OK'], 201);
    }

    public function batch(Request $request)
    {

        /*
[ { "id":99, "lat":-22.921545, "lng":-43.232289,
    "dt":”26/05/2020 15:13:45" },
  { "id":99, "lat":-21.914743, "lng":-42.212672,
    "dt":"26/05/2020 15:13:57" } ]

*/
        $lotes = $request->json();
        //var_dump($lotes);
        //dd($lotes);
        foreach($lotes as $k=>$v){
            $alert = new Alert();
            $alert->device_id = (int) $v['id'];
            $alert->lat = $v['lat'];
            $alert->lng = $v['lng'];
            $alert->dt = $v['dt'];
            $alert->save();
        }
        return response()->json(['status' => 'OK'], 201);
    }


    public function update(Request $request, Alert $alert)
    {
        //
    }

    public function destroy(Alert $alert)
    {
        $alert->delete();
        return back()->with('status', 'Item Deletado com Sucesso');
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
}
