<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 06/12/2017
 * Time: 07:23 PM
 */

namespace App\Models\Management\Relations;

use App\Models\Authentication\Auth;
use App\Models\Management\Company;
use App\Models\Management\RegistrationTypes;

trait CompanyRegistrationRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }
    public function registration()
    {
        return $this->belongsTo(RegistrationTypes::class , 'taxregistration_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class , 'ten_id' , 'id');
    }
}
