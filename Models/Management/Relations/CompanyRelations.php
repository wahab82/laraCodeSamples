<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 29/11/2017
 * Time: 10:22 PM
 */
namespace App\Models\Management\Relations;

use App\Models\Authentication\Auth;
use App\Models\Management\CompanyAddress;

trait CompanyRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }
    public function address()
    {
        return $this->hasMany(CompanyAddress::class , 'ten_id' , 'id');
    }
}