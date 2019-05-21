<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 24/01/2018
 * Time: 09:58 PM
 */
namespace App\Http\Controllers\SystemManagement\Traits;
use Facades\App\Models\Management\Unit;
use Facades\App\Models\Management\Unitclass;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

trait Units
{
    public function getUnitClasses()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Unitclass::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo Unitclass::all();
        }
    }

    public function getUnits()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Unit::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo Unit::with("unitclass")->get();
        }
    }

    public function saveUnitClass()
    {
        $requestObj = new \stdClass();
        try
        {
            $data = Validator::make($this->request->all() , [
                "unitclass" => "required|unique:unitclass,unit_type"
            ]);
            if(! ($data->fails()))
            {
                if($this->request->get("id") > 0)
                {
                    $requestObj = $this->updateUnitClass();
                }
                else{
                    if (Unitclass::saveData($this->request))
                    {
                        $requestObj->status = 'success';
                        $requestObj->msg = 'Unit Class Type Saved Successfully !';
                    }
                    else{
                        $requestObj->status = 'error';
                        $requestObj->msg = 'Unable To Save Data !';
                    }
                }
            }
        else{
                $requestObj->status = 'error';
                $requestObj->msg = 'Class Type Already Exists !';
            }
        }catch (Exception $exception)
        {}
        echo json_encode($requestObj);
    }

    public function updateUnitClass()
    {
        $requestObj = new \stdClass();
        if(Unitclass::exists($this->request))
        {
            if(Unitclass::updateData($this->request))
            {
                $requestObj->status = 'success';
                $requestObj->msg = 'Record Updated Successfully !';
            }
            else{
                $requestObj->status = 'error';
                $requestObj->msg = 'Unable to Update record !';
            }
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Invalid Record !';
        }
        return $requestObj;
    }

    public function editUnitClass()
    {
        $requestObj  = new \stdClass();
        if(Unitclass::exists($this->request)) {
            $requestObj->status = 'success';
            $requestObj->data = Unitclass::where("id", $this->request->get("id"))->first();
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = "Record Doesn't Exist !";
        }
        echo json_encode($requestObj);
    }

    public function saveUnit()
    {
        $requestObj = new \stdClass();
        $data = Validator::make($this->request->all() , [
            "unitCode"  => "required|unique:units,unit_code"
        ]);

            if($this->request->get("id") > 0)
            {
                 // Call the Unit Update Function
                if(Unit::updateData($this->request))
                {
                    $requestObj->status = 'success';
                    $requestObj->msg = 'Unit Updated Successfully !';
                }
                else{
                    $requestObj->status = 'error';
                    $requestObj->msg = 'Something Went Wrong !';
                }
            }
            else{
                // Call The Unit Save Function
                $data = Validator::make($this->request->all() , [
                    "unitCode" => "required|unique:units,unit_code"
                ]);
                if(! $data->fails()){
                    if(Unit::saveData($this->request))
                    {
                        $requestObj->status = 'success';
                        $requestObj->msg = 'Unit Saved Successfully !';
                    }
                    else{
                        $requestObj->status = 'error';
                        $requestObj->msg = 'Something Went Wrong !';
                    }
                }
                else{
                    $requestObj->status = 'error';
                    $requestObj->msg = 'Unit Code Already Exists !';
                }

            }

        echo json_encode($requestObj);
    }

    public function GetUnit()
    {
        $requestObj = new \stdClass();
        $obj = Unit::where("id" , $this->request->get("id"));
        if($obj->count() > 0){
            $requestObj->status = 'success';
            $requestObj->data = $obj->first();
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Record not Exists !';
        }
        echo json_encode($requestObj);
    }

}