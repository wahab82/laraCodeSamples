<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Unitclass extends Model
{
    protected $table = 'unitclass';
    protected $primaryKey = 'id';
    protected $fillable = ['unit_type'];
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query);
    }

    public function saveData($request)
    {
        $obj = new $this;
        $obj->unit_type = $request->get("unitclass");
        $obj->save();
        return 1;
    }

    public function exists($request)
    {
        return $this->where("id" , $request->get("id"))->count() > 0;
    }

    public function updateData($request)
    {
        $obj = $this->where("id",$request->get("id"))->first();
        $obj->unit_type = $request->get("unitclass");
        $obj->save();
        return 1;
    }

}
