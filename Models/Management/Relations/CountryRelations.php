<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 26/11/2017
 * Time: 04:29 PM
 */
namespace App\Models\Management\Relations;
use App\Models\Management\State;

trait  CountryRelations
{
    public function state()
    {
        return $this->hasMany(State::class , 'country_id', 'id');
    }
}