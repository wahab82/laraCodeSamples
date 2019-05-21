<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 07/12/2017
 * Time: 11:15 AM
 */
namespace App\Models\GeneralLedger\Relations;

use App\Models\Authentication\Auth;

trait FinancialDimensionValueRelations
{
    public function createdByAuth()
        {
            return $this->belongsTo(Auth::class , 'created_by' , 'id');
        }
        public function modifiedByAuth()
        {
            return $this->belongsTo(Auth::class , 'modified_by' , 'id');
        }
}