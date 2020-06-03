<?php

namespace App\Http\Controllers;

use App\Fence;
use App\Device;
use App\FenceDevice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        #dd($request);

        $devices = Device::with('fences')->get();
        #$devices = Device::with('fences')->toSql();
        #$devices = Device::all();
        #dd($devices);
        #$fencedevices = FenceDevice::toSql();
        $fencedevices = FenceDevice::all();

        #dd($fencedevices);

        $fences = Fence::all();
        return view('device.index', compact('fences', 'devices', 'fencedevices'));
    }



    public function store(Request $request)
    {
        $this->isValid($request);

        try{
            $device = new Device();
            $device->name =  $request->get('name');
            $device->tel =  $request->get('tel');
            $device->r =  $request->get('r');
            $device->d =  $request->get('d');
            $device->save();

            $fences_id = $request->get('fences_id');
            $device->fences()->sync($fences_id);
            return back()->withErrors( 'erros created successfully ... ');
            #return back()->with('status', 'device created successfully.');

        } catch(Exception $e){
            #Session::flash('message', );

            return back()->with('status', ['text'=>$e->getMessage(),'type'=>'danger'] );
            #echo $e->getMessage();
        }

    }


    public function update(Request $request, int $id)
    {
        $this->isValid($request);


        $device = Device::find($id);
        $device->name =  $request->get('name');
        $device->tel =  $request->get('tel');
        $device->r =  $request->get('r');
        $device->d =  $request->get('d');

        #$fence_id = (int) $request->get('fence_id') ?? 0;
        $device->save();

        #dd($request);

        $fences_id = $request->get('fences_id');

        #dd($fences_id);
        $device->fences()->sync($fences_id);


        return back()->with('status', 'device updated!');
    }


    public function destroy(Device $device)
    {
        $device->delete();
        return back()->with('status', 'Item Deletado com Sucesso');
    }

    public function show(Device $device)
    {
        return view('device.show', compact('device'));
    }






    private function isValid(Request $request)
    {

        $request->only(['name',]);

        $request->validate([
            'name' => 'required|min:2',
        ], [
            'name.required' => 'Nome e obrigatorio',
            'name.min' => 'Minimo de 5 carcateres',
        ]);
        return $request;
    }
}
