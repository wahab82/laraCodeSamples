<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 14/12/2017
 * Time: 09:38 PM
 */
namespace App\Models\GeneralLedger\Relations;

use App\Models\Authentication\Auth;
use App\Models\GeneralLedger\MainAccountType;

trait MainAccountCategoriesRelations
{
    public function mainaccounttype()
    {
        return $this->belongsTo(MainAccountType::class , 'mainaccounttype_id' , 'id');
    }
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }
}