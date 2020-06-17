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
        if(!$user_id > 0){
            return response()->json(['error' => 'Incorrect User'], 406);

        }

        #dd((int) $user_id);
        #dd($cerca);
        $cerca_prepare = json_encode($cerca,JSON_UNESCAPED_SLASHES);
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
        if($devices_id){
            foreach($devices_id as $device_id){
                $devices_com_user[]=compact('device_id','user_id');
            }

            $fence->devices()->sync($devices_com_user);
        }


        #return redirect('fence.index')->withSuccess('fence updated!');
        return redirect()->route('fence.index')->withSuccess('Fence updated!');
    }

    public function getFences (string $tel)
    {

        $device = Device::where('tel','=',$tel)
        ->select('id','user_id','name','t as wait_alert','d as border', 'r as pfence')
        ->with('fences:fence_id,name,fence as coords')->first()->toJson();

        return response()->json(compact('device'),200);
        #return response()->json(['status' => 'ERRO'], 406);

    }


    public function del_device888888888888(int $fence_id, int $device_id)
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
        return back()->withSuccess('Record Deleted with Success');;
    }
}
