<?php
namespace App\Traits;

use App\Tenant;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


trait TenantScoped{
    protected static function bootTenantScoped(){
        static::creating(function (Model $model){
            $model->user_id = (int) Auth::id();
        });
        static::addGlobalScope(new TenantScope());

        static::deleting(function (Model $model){
            if($model->user_id == (int) Auth::id()){

            } else {
                dd('hhh');
                return redirect('login')->with('status', 'erro - nao pertence');

            }

        });


/*         static::addGlobalScope('active', function (Builder $builder) {
            static::deleting(function (Model $m) use ($builder){
                #dd($builder);
                #$builder->where('user_id', (int) Auth::id());
                $builder->where('user_id', 55);
            });
        });
 */

    }

    public function tenant ()
    {
        return $this->belongsTo(Tenant::class);
    }
}
