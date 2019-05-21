<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 18/12/2017
 * Time: 10:43 PM
 */

namespace App\Models\GeneralLedger\Relations;

use App\Models\Authentication\Auth;

trait ChartHeadRelations
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