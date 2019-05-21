<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 20/12/2017
 * Time: 10:54 AM
 */

namespace App\Models\GeneralLedger\Relations;
use App\Models\Authentication\Auth;
use App\Models\GeneralLedger\MainAccountCategories;
use App\Models\GeneralLedger\MainAccountType;

trait ChartofaccountRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class, 'created_by', 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class, 'modified_by', 'id');
    }
    public function mainaccounttype()
    {
        return $this->belongsTo(MainAccountType::class , 'mainaccounttype_id', 'id');
    }
    public function mainaccountcategory()
    {
        return $this->belongsTo(MainAccountCategories::class , 'mainaccountcategory_id' , 'id');
    }
}