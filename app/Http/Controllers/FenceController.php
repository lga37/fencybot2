<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Fence;
use App\Device;
use App\Partner;
use App\FenceDevice;
use Twilio\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FenceController extends Controller
{

    public function index(Request $request)
    {
        #dd($request);


        $fences = Fence::all(['id'])->toArray();
        #dd($fences);
        $ids = array_column($fences,'id');
        #dd($ids);

        $fencedevices = FenceDevice::whereIn('fence_id',$ids)->get();
        #dd($fencedevices);
        $fences = Fence::all();

        return view('fence.index', compact('fences', 'fencedevices'));
    }


    private function isValid(Request $request)
    {

        $request->only(['name', 'fence',]);

        $request->validate([
            'name' => 'required|min:2',
            'fence' => 'required|json',
        ]);
        return $request;
    }

    public function store(Request $request)
    {
    }

    public function add(Request $request)
    {
        $name = $request->json('name');
        ### atencao aqui, pois se usar fence p json e fence p model da aquela baita confusao
        $cerca = $request->json('fence');
        $user_id = (int) $request->json('user_id');
        if (!$user_id > 0) {
            return response()->json(['error' => 'Incorrect User'], 406);
        }

        #dd((int) $user_id);
        #dd($cerca);
        $cerca_prepare = json_encode($cerca, JSON_UNESCAPED_SLASHES);
        #dd($cerca_prepare);

        $fence = new Fence();  #############)->withoutGlobalScopes();
        $fence->name =  $name;
        //json_encode($array,JSON_UNESCAPED_SLASHES);
        $fence->fence = $cerca_prepare;
        #vou testar o scoped
        $fence->user_id = $user_id;
        $fence->save();


        return response()->json(['status' => 'OK'], 201);
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


    public function show($id)
    {
        $fence = fence::find($id);
        return view('fence.show', compact('fence'));
    }

    public function edit(Fence $fence)
    {
        return view('fence.edit', compact('fence'));
    }

    public function update(Request $request, Fence $fence)
    {
        #$this->isValid($request);

        $fence->name =  $request->get('name');
        $fence->save();

        $devices_id = $request->get('devices_id');
        #dd($devices_id);

        $user_id = (int) Auth::id();
        if ($devices_id) {
            foreach ($devices_id as $device_id) {
                $devices_com_user[] = compact('device_id', 'user_id');
            }

            $fence->devices()->sync($devices_com_user);
        } else {
            $fence->devices()->sync([]);
        }


        #return redirect('fence.index')->withSuccess('fence updated!');
        return redirect()->route('fence.index')->withSuccess('Fence updated!');
    }

    private function getDevicesByTel($tel)
    {
        $devices_id = Device::where('tel', $tel)->select('id')->get()->toArray();

        #dd($devices_id);
        return $devices_id;
    }

    public function getFences(string $tel)
    {
        $devices = $this->getDevicesByTel($tel);

        #dump($devices);
        if (!$devices) {
            return response()->json(['status' => 'ERROR'], 406);
        }

        $device_id = (int) $devices[0]['id'];
        #dump($device_id);
        $partners = Device::join('partners', function ($join) use ($device_id) {
            $join->on('partners.partner_id', '=', 'devices.id')
                #->where('devices.user_id', '=', (int) Auth::id())
                ->where('partners.device_id', '=', $device_id);
        })->select('tel')->get()->toArray();

        #dump($partners);

        $tels = $partners ? array_column($partners, 'tel') : [];
        #dump($tels);

        $device = Device::where('tel', '=', $tel)

            ->select('id', 'user_id', 'name', 't as wait_alert', 'd as border', 'r as pfence')
            ->with('fences:fence_id,name,fence as coords')
            ->first();

        $device->partners = $tels;
        #dd($device);
        if (!$device) {
            return response()->json(['status' => 'ERROR'], 406);
        }
        $device->toArray();
        return response()->json(compact('device'), 200);
    }



    public function destroy(Fence $fence)
    {
        $fence->delete();
        return back()->withSuccess('Record Deleted with Success');;
    }
}
