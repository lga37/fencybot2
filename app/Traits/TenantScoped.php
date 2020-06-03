<?php
namespace App\Traits;

use App\Tenant;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


trait TenantScoped{
    protected static function bootTenantScoped(){
        static::creating(function (Model $model){
            $model->user_id = (int) Auth::id();
        });
        static::addGlobalScope(new TenantScope());
    }

    public function tenant ()
    {
        return $this->belongsTo(Tenant::class);
    }
}
