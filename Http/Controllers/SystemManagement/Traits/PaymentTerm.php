<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 10/12/2017
 * Time: 05:01 PM
 */

namespace App\Http\Controllers\SystemManagement\Traits;

use App\Models\Management\PaymentMethod;

trait PaymentTerm
{
    public function getPaymentMethods()
    {
        return PaymentMethod::GetAll();
    }

    public function getPaymentTerms()
    {
         if ($this->request->has('take'))
         {
             $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = \App\Models\Management\PaymentTerm::class;
             $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
             echo shapeWithKendo($skip , $take , $data->count() , $data->get());
         }
         else{
            echo \App\Models\Management\PaymentTerm::all();
         }
    }

    public function savePaymentTerm()
    {
        $returnObj = new \stdClass();
        if ( (new \App\Models\Management\PaymentTerm())->savePaymentTerm($this->request) > 0 )
        {
            $returnObj->responseStatus = "success";
            $returnObj->msg = 'Payment Term Saved Successfully !';
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($returnObj);
    }
}