<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

class Orderer
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function first()
    {
        #return static::orderBy('order', 'asc')->first()->order - 1;
        return $this->model->query()->orderBy('order', 'asc')->first()->order - 1;
    }

    public function last()
    {
        #return static::orderBy('order', 'desc')->first()->order + 1;
        return $this->model->query()->orderBy('order', 'desc')->first()->order + 1;
    }


    public function after()
    {
        $adjacent = $this->model->query()->where('order', '>', $this->model->order)
            ->orderBy('order', 'asc')
            ->first();

        if (!$adjacent) {
            return $this->last();
        }

        return ($this->model->order + $adjacent->order) / 2;
    }

    public function before()
    {
        $adjacent = $this->model->query()->where('order', '<', $this->model->order)
            ->orderBy('order', 'desc')
            ->first();

        if (!$adjacent) {
            return $this->first();
        }
        return ($this->model->order + $adjacent->order) / 2;
    }

    /*
    reset
    Route::get('/steps/refresh',function(){
        return Step::orderBy('order','asc')->get()->each(function($step,$index){
            $step->update([
                'order'=>$index+1
            ]);
        });
    });

    realocar
    Route::get('/steps/update',function(){
        $step = Step::find(1)->ordering()->before();
        Step::find(4)->update([
            'title'=> '2222newwwww',
            'order' => $step,
        ]);
    });


    */
}
