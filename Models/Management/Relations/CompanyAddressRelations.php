<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 04/12/2017
 * Time: 10:15 PM
 */
namespace  App\Models\Management\Relations;
use App\Models\Authentication\Auth;
use App\Models\Management\City;
use App\Models\Management\Company;
use App\Models\Management\Country;
use App\Models\Management\State;

trait CompanyAddressRelations
{
    public function company()
    {
        return $this->belongsTo(Company::class , 'ten_id','id');
    }
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class , 'state_id' , 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class , 'city_id' , 'id');
    }
}
























