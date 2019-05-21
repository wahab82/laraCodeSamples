<?php

namespace App\Models\MasterPlanning;

use App\Models\MasterPlanning\Relations\ModuleMaskRelation;
use Illuminate\Database\Eloquent\Model;

class ModuleMaskMap extends Model
{
    use ModuleMaskRelation;
    protected $table = 'modulemaskmap';
    protected $primaryKey = 'id';
    protected $fillable = ["module_id","mask_id","module" , "ten_id","created_by"];

    public function saveModuleMaskMap($request)
    {
        $obj = new $this;
        $obj->module_id = $request->get("module");
        $obj->mask_id = $request->get("masking");
        $obj->column = $request->get("column");
        $obj->ten_id = ten();
        $obj->created_by = auth()->user()->id;
        return $obj->save();
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with("module" , "mask"));
    }
}
