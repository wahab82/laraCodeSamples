<?php

namespace App\Models\MasterPlanning;

use Illuminate\Database\Eloquent\Model;

class Masks extends Model
{
    protected $table = 'masks';
    protected $fillable = ['module','masks','ten_id'];
    protected $primaryKey = 'id';
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
        return $this->where('ten_id' ,'=',ten())->where("module",'=',$request->get("module"))->count();
    }

    public function saveMasks($request)
    {
        $obj = new $this;

        $obj->module = $request->get("module");
        $obj->masks = $request->get("masks");
        $obj->ten_id = $this->user->ten_id;
        $obj->save();
    }
}
