<?php

namespace App\Models\MasterPlanning;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';
    protected $primaryKey = 'id';
    protected $fillable = ['module','display'];

    public function saveModules($module , $display)
    {
        $obj = new $this;
        $obj->module = $module;
        $obj->display = $display;
        $obj->save();
    }
}
