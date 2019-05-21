<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 13/01/2018
 * Time: 10:28 PM
 */
namespace App\Models\MasterPlanning\Relations;

use App\Models\MasterPlanning\Modules;
use App\Models\MasterPlanning\Masks;

trait ModuleMaskRelation
{

    public function module()
    {
        return $this->belongsTo(Modules::class , 'module_id' , 'id');
    }

    public function mask()
    {
        return $this->belongsTo(Masks::class , 'mask_id' , 'id');
    }


}