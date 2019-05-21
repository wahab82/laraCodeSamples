<?php

namespace App\Models\MasterPlanning;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $table = 'segments';
    protected $primaryKey = 'id';
    protected $fillable = ['segment' , 'default' , 'length'];


    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query);
    }

    public function isExists($request)
    {
        return $this->where("segment" , '=' , $request->get("segment"))->count();
    }

    public function saveSegment($request)
    {
        $obj = new $this;
        $obj->segment = $request->get("segment");
        $obj->default = $request->get("default");
        $obj->length = $request->get("length");
        $obj->save();
    }
}
