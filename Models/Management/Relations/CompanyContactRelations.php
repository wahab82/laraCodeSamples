<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 05/12/2017
 * Time: 12:37 AM
 */
namespace App\Models\Management\Relations;
use App\Models\Authentication\Auth;
use App\Models\Management\Company;
use App\Models\Management\ContactType;

trait  CompanyContactRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class , 'ten_id','id');
    }
    public function contacttype()
    {
        return $this->belongsTo(ContactType::class , 'contacttype_id' , 'id');
    }
}