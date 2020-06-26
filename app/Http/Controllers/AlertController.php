<?php

namespace App\Http\Controllers;

use App\User;
use App\Alert;
use App\Fence;
use App\Device;
use App\Events\EventAlert;
use App\FenceDevice;
use App\Notifications\AlertEmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Notifications\TelegramNotification;

class AlertController extends Controller
{

    public function index(Request $request)
    {

        $devices = Device::all();
        $fences = Fence::all();

        $alerts = Alert::join('devices', function ($join) {
            $join->on('alerts.device_id', '=', 'devices.id')->where('devices.user_id', '=', (int) Auth::id());
        })->with(['fence', 'device'])->distinct()->get();


        return view('alert.index', compact('fences', 'devices', 'alerts'));
    }

    public function hist(Request $request)
    {
        $devices = Device::all();

        //$alerts = Alert::where('type',0)->orderBy('device_id')->with(['device'])->get();
        //$alerts = Alert::orderBy('device_id')->with(['device'])->get();

        $alerts = Alert::join('devices', function ($join) {
            $join->on('alerts.device_id', '=', 'devices.id')->where('devices.user_id', '=', (int) Auth::id());
        })->where('type', 0)->orderBy('device_id')->with(['fence', 'device'])->get();

        return view('alert.hist', compact('devices', 'alerts'));
    }

    public function invasions(Request $request)
    {
        $devices = Device::all();

        $alerts = Alert::join('devices', function ($join) {
            $join->on('alerts.device_id', '=', 'devices.id')->where('devices.user_id', '=', (int) Auth::id());
        })
            ->whereIn('type', [2, 3])
            ->with(['device'])->get();


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
            $join->on('alerts.device_id', '=', 'devices.id')->where('devices.user_id', '=', (int) Auth::id());
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

        return view('alert.hist', compact('devices', 'alerts','device_id'));
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
        #dd($lotes);
        #dd($request->getContent());


        if ($devices->count() > 0) {
            $devices->each(function ($item, $key) use ($lotes) {
                foreach ($lotes as $v) {
                    if(!$v['fence_id']>0){
                        dd('fence_id is missing');
                        return response()->json(['status' => 'fence_id is missing'], 406);
                    }
                    $exists = FenceDevice::where('fence_id','=',$v['fence_id'])
                    ->where('device_id','=',$item->id)
                    ->where('user_id','=',$item->user_id)->exists();
                    #dd($exists);
                    #if(!$exists) continue;
                    if(!$exists){
                        dd('device_id/user_id mismatch');
                        return response()->json(['status' => 'device_id/user_id mismatch'], 406);
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
                    $alert->save();
                    $user_id = (int) $item->user_id;

                    $user = User::find($user_id);
                    //$user->notify((new AlertEmitted($alert)));
                    //event(new EventAlert($alert));
                }
            });
        } else {
            return response()->json(['status' => 'ERROR'], 406);
        }


        return response()->json(['status' => 'OK'], 201);
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

        dd($request);

        $request->validate([
            'ids'   => 'bail|required|array',
            'ids.*' => 'exists:alerts,id',
        ]);

        Alert::whereIn('id', request('ids'))->delete();

        return back()->withSuccess('Record Deleted with Success');

        #return response(null, Response::HTTP_NO_CONTENT);

    }
}
