<?php
namespace App\Scopes;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;


###
class TenantScope implements Scope {
    public function apply (Builder $builder, Model $model)
    {
        #if(Auth::check()){
        if(Auth::id() > 0){
            # cuidado se tipar (int) ele vai pegar todos , pois todos def sao 0
            #dd($user_id);
            $user_id=(int) Auth::id();
            #dd($model->getTable());
            $builder->where($model->getTable().'.user_id',$user_id);
        } else {
            return redirect('login');
        }
            #echo $builder->toSql();



    }
}
