<?php

namespace App\Traits;

use App\History;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

trait Historyable
{

    public static function bootHistoryable()
    {
        #parent::boot();
        static::updated(function (Model $model) {

            collect($model->getWantedChangedColumns($model))->each(function($change) use ($model){
                $model->saveChange($change);

            });
        });
    }

    protected function saveChange (array $change)
    {
        $this->history()->create([
            'changed_column' => $change['column'],
            'changed_value_from' => $change['from'],
            'changed_value_to' => $change['to'],
        ]);
    }

    protected function getWantedChangedColumns(Model $model)
    {
        return collect(
            array_diff(
                Arr::except($model->getChanges(),$this->ignoreHistoryColumns()),
                $original = $model->getOriginal()
            )
        )->map(function ($change, $column) use ($original) {
            return [
                'column'=> $column,
                'from'=> Arr::get($original, $column),
                'to'=> $change,
            ];

        });
    }

    public function ignoreHistoryColumns ()
    {
        return [
            'updated_at',
        ];
    }

    public function history()
    {
        return $this->morphMany(History::class, 'historyable')
            ->oldest();
    }
}
