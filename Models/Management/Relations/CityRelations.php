<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 26/11/2017
 * Time: 04:29 PM
 */

namespace App\Models\Management\Relations;

use App\Models\Management\State;

trait CityRelations
{
    public function state()
    {
        return $this->belongsTo(State::class , 'state_id','id');
    }
}