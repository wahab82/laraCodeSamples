<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'sidenav';
    protected $primaryKey = 'id';

    public function parents()
    {
        return $this->belongsTo(Modules::class , 'parent_id' , 'id')->where('id','!=',null);
    }

    public function scopeLoadData($query , $filter)
    {
       return $filter->apply($query->with('parents'));
    }

    public function saveModule($request)
    {
        $obj = new $this;
        $obj->link = $request->get("moduleName");
        $obj->redirect = $request->get("link");
        $obj->parent_id = $request->get("parent");
        $obj->is_active = $request->get("status");
        $obj->save();
        return 1;
    }
}
