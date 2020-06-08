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

        #$devices = Device::with('fences')->get();
        $devices = Device::all();
        $fences = Fence::all();
        $fencedevices = FenceDevice::all();

        #dd($devices);
        #$user_id = (int) Auth::id();
        $alerts = Alert::with(['fence','device'])->get();

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
            'name' => 'required|min:2',
            'fence' => 'required|json',
        ],[
            'name.required' => 'Nome e obrigatorio',
            'name' => 'A cerca deve ser um JSON valido',
            'name.min' => 'Minimo de 2 carcateres',
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
        #$user_id = $request->json('user_id');

        #dd((int) $user_id);

        $fence = new Fence();
        $fence->name =  $name;
        $fence->fence =  json_encode($cerca,true);
        #vou testar o scoped
        #$fence->user_id = (int) $user_id;
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
        $fence->save();

        #dd($request);
        $devices_id = $request->get('devices_id');

        $user_id = (int) Auth::id();
        foreach($devices_id as $device_id){
            $devices_com_user[]=compact('device_id','user_id');
        }

        $fence->devices()->sync($devices_com_user);


        return redirect('fence.index')->with('alert', 'fence updated!');
    }

    public function getFences (string $tel)
    {

        $devices = Device::where('tel','=',$tel)->select('id','name')
        ->with('fences:name,fence as coords')->get();

        return response()->json(compact('devices'),200);
        #return response()->json(['status' => 'ERRO'], 406);

    }


    public function del_device(int $fence_id, int $device_id)
    {
        #$this->isValid($request);

        #$fence_id =  (int) $request->get('fence_id');
        #$device_id =  (int) $request->get('device_id');
        $user_id = Auth::id(); #ver se pertence ao usuario

        $fence = Fence::find($fence_id);
        $fence->devices()->detach($device_id);

        return redirect('fence.index')->with('alert', 'fence updated!');
    }


    public function destroy(Fence $fence)
    {
        $fence->delete();
        return back()->with('status', 'Item Deletado com Sucesso');
    }
}
