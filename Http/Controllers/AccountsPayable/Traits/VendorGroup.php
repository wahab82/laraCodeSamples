<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 11/12/2017
 * Time: 12:00 AM
 */
namespace App\Http\Controllers\AccountsPayable\Traits;
use \App\Models\AccountsPayable\VendorGroup as VendorGroupModel;
trait VendorGroup
{
    public function getAllVendorGroups()
    {
         if ($this->request->has('take'))
         {
             $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = VendorGroupModel::class;
             $data = $model::GetAll($this->filter)->where("ten_id" , '=',ten());
             echo shapeWithKendo($skip , $take , $data->count() , $data->get());
         }
         else{
            echo VendorGroupModel::all();
         }
    }

    public function saveVendorGroup()
    {
        $returnObj = new \stdClass();
        if ( ( new VendorGroupModel())->saveVendorGroup($this->request) > 0)
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Vendor Group Saved Successfully !';
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($returnObj);
    }
}