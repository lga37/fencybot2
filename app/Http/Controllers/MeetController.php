<?php

namespace App\Http\Controllers;

use App\Meet;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetController extends Controller
{

    public function index()
    {
        $meets = Meet::all();
        return view('meet.index',compact('meets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $collect = collect($request->json());
        $json = $request->json();

        $coords=[];
        foreach ($json as $k => $v) {
            if($k=='lat' || $k=='lng')
                $coords[$k][] = $v;
        }

        #dd(array_column);

        DB::beginTransaction();
        try {
            $meet = new Meet();
            $meet->coords = json_encode($coords);
            $meet->save();
            $tracks = [];
            foreach ($json as $k => $v) {
                $tracks[] = new Track($v);
            }
            $meet->tracks()->saveMany($tracks);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            $success = false;
            DB::rollback();
        }


        /*         array:1 [
            "\x00*\x00parameters" => array:2 [
              0 => array:6 [
                "id" => 99
                "type" => 2
                "lat" => -22.921545
                "lng" => -43.232289
                "dist" => 15.3
                "dt" => "26/05/2020 15:13:45"
              ]
              1 => array:6 [
                "id" => 99
                "type" => 1
                "lat" => -22.921545
                "lng" => -43.232289
                "dist" => 0
                "dt" => "26/05/2020 15:13:57"
              ]
            ]
          ]
 */
        return response()->json(['status' => $success], 201);
    }

    public function show(Meet $meet)
    {
        //
    }

    public function edit(Meet $meet)
    {
        //
    }

    public function update(Request $request, Meet $meet)
    {
        //
    }

    public function destroy(Meet $meet)
    {
        $meet->delete();
        return back()->with('status', 'Item Deletado com Sucesso');
    }
}
