<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 13/12/2017
 * Time: 10:26 PM
 */

namespace App\Models\GeneralLedger\Relations;

use App\Models\Authentication\Auth;
use App\Models\GeneralLedger\FinancialDimension;
use App\Models\GeneralLedger\FinancialDimensionSet;

trait FinancialDimensionSetDetailRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }

    /* Financial Dimension Sets */
    public function financialdimset()
    {
        return $this->belongsTo(FinancialDimensionSet::class , 'financialdimset_id' , 'id');
    }

    /* Financial Dimensions */
    public function financialdim()
    {
        return $this->belongsTo(FinancialDimension::class , 'financialdim_id','id');
    }
}