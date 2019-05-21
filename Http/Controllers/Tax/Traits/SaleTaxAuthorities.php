<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 27/01/2018
 * Time: 10:59 AM
 */

namespace App\Http\Controllers\Tax\Traits;

use Facades\App\Models\Tax\SaleTaxAuthority;


trait SaleTaxAuthorities
{
    public function getSaleTaxAuthorities()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = SaleTaxAuthority::class;
            $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo SaleTaxAuthority::all();
        }
    }

    public function saveTaxAuthority()
    {
        $requestObj = new \stdClass();
        $data = Validate($this->request->all() , [
            "authority" => "required|unique:saletaxauthority,authority"
        ]);

        if(! $data->fails())
        {
            if(SaleTaxAuthority::saveAuthority($this->request))
            {
                $requestObj->status = 'success';
                $requestObj->msg = 'Authority Saved Successfully !';
            }
            else{
                $requestObj->status = 'error';
                $requestObj->msg = 'Something Went Wrong !';
            }
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Invalid Data Passed !';
        }
        echo json_encode($requestObj);
    }

    public function getAuthorityDetails($id)
    {
        $requestObj = new \stdClass();
        if(($data = SaleTaxAuthority::exists($id)) != null)
        {
            $requestObj->status = 'success';
            $requestObj->address = $data->authorityaddress();
            $requestObj->contact = $data->authoritycontact();
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Record Not Found !';
        }
        echo json_encode($requestObj);
    }


}