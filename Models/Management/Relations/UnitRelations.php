<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 26/01/2018
 * Time: 08:18 AM
 */
namespace App\Models\Management\Relations;

use App\Models\Management\Unitclass;

trait UnitRelations
{
    public function unitclass()
    {
        return $this->belongsTo(Unitclass::class , 'unitclass_id', 'id');
    }
}