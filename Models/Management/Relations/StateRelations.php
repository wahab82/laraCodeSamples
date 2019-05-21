<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 26/11/2017
 * Time: 04:30 PM
 */

namespace App\Models\Management\Relations;

use App\Models\Management\City;
use App\Models\Management\Country;

trait StateRelations
{
    public function city()
    {
        return $this->hasMany(City::class , 'state_id','id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id','id');
    }
}