<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 10/12/2017
 * Time: 06:46 PM
 */

namespace App\Models\Management\Relations;

use App\Models\Authentication\Auth;
use App\Models\Management\PaymentMethod;

trait PaymentTermRelations
{
    public function createdByAuth()
        {
            return $this->belongsTo(Auth::class , 'created_by' , 'id');
        }
        public function modifiedByAuth()
        {
            return $this->belongsTo(Auth::class , 'modified_by' , 'id');
        }

        public function paymentmethod()
        {
            return $this->belongsTo(PaymentMethod::class,'paymethod_id','id');
        }
}