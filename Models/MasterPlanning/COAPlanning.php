<?php

namespace App\Models\MasterPlanning;

use Illuminate\Database\Eloquent\Model;

class COAPlanning extends Model
{
    protected $table = 'coaplanning';
    protected $primaryKey = 'id';
    protected $fillable = ['levels' , 'space' , 'ten_id'];
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query);
    }

    public function isExists($request)
    {
        return $this->where("ten_id",'=',$this->user->ten_id)->where("levels" , '=',$request->get("levels"))->count();
    }
    public function savePlanning($request)
    {
        $obj = new $this;
        $obj->levels = $request->get("levels");
        $obj->space = $request->get("space");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->save();
    }
}
