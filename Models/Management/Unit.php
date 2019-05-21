<?php

namespace App\Models\Management;

use App\Models\Management\Relations\UnitRelations;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use UnitRelations;
    protected $table = 'units';
    protected $primaryKey = 'id';
    protected $fillable = ['unit_code' , 'unit_description' , 'unitclass_id'];
    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with("unitclass"));
    }

    public function saveData($request)
    {
        $obj = new $this;
        $obj->unit_code = $request->get("unitCode");
        $obj->unit_description = $request->get("unitDescription");
        $obj->unitclass_id = $request->get("unitClass");
        $obj->save();
        return 1;
    }

    public function updateData($request)
    {
        $obj = $this->where("id" , $request->get("id"));
        if($obj->count() > 0)
        {
            $obj = $obj->first();
            $obj->unit_code = $request->get("unitCode");
            $obj->unit_description = $request->get("unitDescription");
            $obj->unitclass_id = $request->get("unitClass");
            $obj->save();
            return 1;
        }
        else{
            return 0;
        }
    }
}
