<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 10/12/2017
 * Time: 11:09 PM
 */

namespace App\Models\AccountsPayable\Relations;

use App\Models\Authentication\Auth;
use App\Models\Management\PaymentTerm;

trait VendorGroupRelations
{
    public function createdByAuth()
        {
            return $this->belongsTo(Auth::class , 'created_by' , 'id');
        }
        public function modifiedByAuth()
        {
            return $this->belongsTo(Auth::class , 'modified_by' , 'id');
        }
        public function payterm()
        {
            return $this->belongsTo(PaymentTerm::class , 'payterm_id' ,'id');
        }
}