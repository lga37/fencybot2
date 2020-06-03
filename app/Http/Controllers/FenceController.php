<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Fence;
use App\Device;
use App\FenceDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FenceController extends Controller
{

    public function index(Request $request)
    {
        #dd($request);

        $devices = Device::with('fences')->get();
        #$devices = Device::all();
        $fencedevices = FenceDevice::all();

        #dd($devices);

        $alerts =[];
        #$alerts = Alert::with('fence___device')->get()->toArray();
        $alerts = Alert::all();

        $fences = Fence::all();
        return view('fence.index', compact('fences','devices','alerts','fencedevices'));
    }

    public function create()
    {
        $fence = [];
        return view('fence.create',compact('fence'));
    }

    private function isValid(Request $request){

        $request->only(['name', 'fence', ]);

        $request->validate([
            #'name' => 'required|min:5',
            #'fence' => 'required|json',
        ],[
            #'name.required' => 'Nome e obrigatorio',
            #'name.min' => 'Minimo de 5 carcateres',
        ]);
        return $request;
    }

    public function store(Request $request)
    {
        #dd($request->all());
        #$this->isValid($request);

        $fence = new Fence();
        $fence->name =  $request->get('name');
        $fence->fence = $request->get('fence');
        $fence->user_id = Auth::id() ?? 1;

        $fence->save();

        return response()->json(['status' => 'OK'], 201);

    }

    public function add(Request $request)
    {
        $name = $request->json('name');

        ### atencao aqui, pois se usar fence p json e fence p model da aquela baita confusao
        $cerca = $request->json('fence');

        $fence = new Fence();
        $fence->name =  $name;
        $fence->fence =  json_encode($cerca);
        $fence->user_id = 5;
        $fence->save();
        return response()->json(['status' => 'OK'], 201);

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
        $this->isValid($request);

        $fence->name =  $request->get('name');
        #$fence->fence = $request->get('fence');
        $fence->save();

        #dd($request);
        $devices_id = $request->get('devices_id');
        $fence->devices()->sync($devices_id);


        return redirect('/fence')->with('alert', 'fence updated!');
    }

    public function getFences (string $tel)
    {

        $devices = Device::where('tel','=',$tel)->select('id','name','user_id')
        ->with('fences:name,fence')->with('user:id,name')->get();

        return response()->json(compact('devices'),200);

    }


    public function del_device(int $fence_id, int $device_id)
    {
        #$this->isValid($request);

        #$fence_id =  (int) $request->get('fence_id');
        #$device_id =  (int) $request->get('device_id');
        $user_id = Auth::id(); #ver se pertence ao usuario

        $fence = Fence::find($fence_id);
        $fence->devices()->detach($device_id);

        return redirect('/fence')->with('alert', 'fence updated!');
    }


    public function destroy(Fence $fence)
    {
        $fence->delete();
        return back()->with('status', 'Item Deletado com Sucesso');
    }
}
