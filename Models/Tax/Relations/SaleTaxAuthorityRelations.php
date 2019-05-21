<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 28/01/2018
 * Time: 12:46 AM
 */

namespace App\Models\Tax\Relations;
use App\Models\Tax\SaleTaxAuthorityContact;
use App\Models\Tax\SaleTaxAuthorityAddress;

trait SaleTaxAuthorityRelations
{
    public function authorityaddress()
    {
        return $this->hasMany(SaleTaxAuthorityAddress::class , 'saletaxauthority_id' , 'id');
    }

    public function authoritycontact()
    {
        return $this->hasMany(SaleTaxAuthorityContact::class , 'saletaxauthority_id','id');
    }
}