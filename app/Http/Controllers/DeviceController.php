<?php

namespace App\Http\Controllers;

use App\Fence;
use Exception;
use App\Device;
use App\Partner;
use App\FenceDevice;


use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::all();
        #$fencedevices = FenceDevice::all();
        $trackeds = Device::join('fence_device', function ($join) {
            $join->on('fence_device.device_id', '=', 'devices.id');
        })->orderBy('devices.id')->with(['fences'])
            ->select('devices.*')->distinct()->get();


        $tracked_ids = $trackeds->pluck('id')->toArray();

        #dump($tracked_ids);

        $not_trackeds = Device::whereNotIn('id', $tracked_ids)
            ->orderBy('id')->get();




        #dd($not_trackeds);


        $fences = Fence::all();
        #dd($fencedevices);


        return view('device.index', compact('fences', 'trackeds', 'not_trackeds'));
    }



    public function store(Request $request)
    {
        $this->isValid($request);

        #dd($request);

        try {
            $device = new Device();
            $device->name =  $request->get('name');
            $device->tel =  $request->get('tel');
            #$device->r =  $request->get('r');
            #$device->d =  $request->get('d');
            #$device->t =  $request->get('t');


            #$device->user_id = (int) Auth::id();
            $device->save();



            #$fences_id = $request->get('fences_id');
            #$device->fences()->sync($fences_id);
            return back()->withSuccess('Record Inserted with Success');
            #return back()->with('status', 'device created successfully.');

        } catch (Exception $e) {
            //dd($e);
            #Session::flash('message', );
            #return redirect()->to('/here')->withErrors(['message1'=>'this is first message']);
            return back()->withError('Error on Database processing: ' . $e->getMessage());
            #return back()->with('status', ['text'=>$e->getMessage(),'type'=>'danger'] );
            #echo $e->getMessage();
        }
    }







    public function untrack(Request $request, int $id)
    {
        #dd($request->get('partners'));


        $device = Device::find($id);
        $device->fences()->sync([]);


        return back()->withSuccess('Record Untracked with Success');
    }




    public function update(Request $request, int $id)
    {
        #dd($request->get('partners'));

        $this->isValid($request);


        $device = Device::find($id);
        $device->name =  $request->get('name');
        $device->tel =  $request->get('tel');
        #$device->t =  $request->get('t');
        #$device->r =  $request->get('r');
        #$device->d =  $request->get('d');
        #$device->partners =  trim($request->get('partners'),',');

        #dd($device);

        $device->save();

        $fences_id = (array) $request->get('fences_id'); #fazer essa tipagem, se nao tiver exclui

        #dd($fences_id);
        if ($fences_id) {

            $fences_com_user = [];
            $user_id = (int) Auth::id();

            foreach ($fences_id as $fence_id) {
                $fences_com_user[] = compact('fence_id', 'user_id');
            }
            $device->fences()->sync($fences_com_user);
        } else {
            $device->fences()->sync([]);
        }


        return back()->withSuccess('Record Updated with Success');
    }



    public function patch(Request $request, int $id)
    {
        #dd($request->get('partners'));

        $this->isValid($request);


        $device = Device::find($id);
        $device->name =  $request->get('name');
        $device->tel =  $request->get('tel');
        #$device->t =  $request->get('t');
        #$device->r =  $request->get('r');
        #$device->d =  $request->get('d');
        #$device->partners =  trim($request->get('partners'),',');

        #dd($device);

        $device->save();

        return back()->withSuccess('Record Updated with Success');
    }


    public function destroy(Device $device)
    {
        $device->delete();
        return back()->withSuccess('Record Deleted with Success');
    }

    public function configure(Request $request)
    {
        #dump($request->post('r')?1:0);
        #dd($request->post());
        $id = (int) $request->post('device_id');
        $device = Device::findOrFail($id);
        $device->t =  $request->post('t');
        $device->r =  $request->post('r');
        $device->d =  $request->post('d');
        $device->save();

        $fences_id = (array) $request->post('associated_fences'); #fazer essa tipagem, se nao tiver exclui
        #dd($fences_id);
        #$request->validate([
        #    'fences_id'   => 'bail|array',
        #    'fences_id.*' => 'exists:fences,id',
        #]);

        if ($fences_id) {
            $fences_com_user = [];
            $user_id = (int) Auth::id();
            foreach ($fences_id as $fence_id) {
                $fences_com_user[] = compact('fence_id', 'user_id');
            }
            $device->fences()->sync($fences_com_user);
        } else {
            $device->fences()->sync([]);
        }

        $partners_id = (array) $request->post('partners'); #fazer essa tipagem, se nao tiver exclui
        #dd($partners_id);
        #dd($device);
        if ($partners_id) {
            $device->partners()->delete();
            $partners = [];
            foreach ($partners_id as $partner_id) {
                if ($id != $partner_id) {
                    $p = new Partner();
                    $p->partner_id = (int) $partner_id;
                    $partners[] = $p;
                }
            }
            $device->partners()->saveMany($partners);
        } else {
            $device->partners()->delete();
            //$device->partners()->saveMany([]);

        }

        return back()->withSuccess('Record Updated with Success');
    }

    public function show(Device $device)
    {
        #dd($device);

        $fences = Fence::all(['id', 'name'])->toArray();
        #dump($fences);

        $fencedevices_pre = FenceDevice::where('device_id', '=', (int) $device->id)->select('fence_id', 'device_id')->get()->toArray();
        #dump($fencedevices_pre);

        $fencedevices = Fence::whereIn('id', array_column($fencedevices_pre, 'fence_id'))->select('id', 'name')->get()->toArray();
        #dump($fencedevices);

        $nao_fences = array_diff(array_column($fences, 'id'), array_column($fencedevices_pre, 'fence_id'));
        #dump($nao_fences);

        $nao_fencedevices = Fence::whereIn('id', array_values($nao_fences))->select('id', 'name')->get()->toArray();
        #dd($nao_fencedevices);

        #############################################################################################
        $devices = Device::all(['id', 'name'])->toArray();
        #dump($devices);

        $partners_pre = Partner::where('device_id', '=', (int) $device->id)->select('device_id', 'partner_id')->get()->toArray();
        #dump($partners_pre);
        $partners = Device::whereIn('id', array_column($partners_pre, 'partner_id'))->select('id', 'name')->get()->toArray();

        #dd($partners);

        $nao_partners = array_diff(array_column($devices, 'id'), array_column($partners_pre, 'partner_id'));
        #dump($nao_partners);

        $nao_partners = Device::whereIn('id', array_values($nao_partners))->select('id', 'name')->get()->toArray();
        #dd($nao_partners);

        $devices = Device::all(['id', 'name']); #tive q chamar de novo, manter isso

        return view('device.show', compact('device', 'devices','nao_partners', 'nao_fencedevices', 'partners', 'fencedevices'));
    }


    private function isValid(Request $request)
    {

        $request->only(['name',]);

        $request->validate([
            'name' => 'required|min:2',
        ]);

        return $request;
    }
}
