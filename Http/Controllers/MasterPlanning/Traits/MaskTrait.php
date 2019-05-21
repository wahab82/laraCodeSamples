<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 07/01/2018
 * Time: 11:19 AM
 */

namespace App\Http\Controllers\MasterPlanning\Traits;


use Facades\App\Models\MasterPlanning\ModuleMaskMap;
use Facades\App\Models\MasterPlanning\MaskSegment;
use Facades\App\Models\MasterPlanning\Masks;
use Facades\App\Models\MasterPlanning\Modules;

trait MaskTrait
{
    public function GetMaskings()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Masks::class;
            $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo Masks::where("ten_id" , '=',ten())->get();
        }
    }

    public function SaveMaskings()
    {
        $requestObj = new \stdClass();

       if(Masks::isExists($this->request) > 0)
       {
            $requestObj->status = 'error';
            $requestObj->msg = 'Module Already Exists';
       }
       else{
           Masks::saveMasks($this->request);
           $requestObj->status = 'success';
           $requestObj->msg = 'Masks Saved Successfully !';
       }
        echo json_encode($requestObj);
    }

    public function getMaskSegment($mask)
    {
        $requestObj = new \stdClass();
        $requestObj->msg = 'success';
        $requestObj->data = MaskSegment::GetSegment($mask)->get();
        echo json_encode($requestObj);
    }

    public function hasMaskSegment($segment , $mask)
    {
        $requestObj = new \stdClass();
        $requestObj->data = MaskSegment::where("mask_id",$mask)->where("segment_id",$segment)->count();
        $requestObj->msg = 'success';
        echo json_encode($requestObj);
    }

    public function dropSegment($id)
    {
        $requestObj = new \stdClass();
        $segment = MaskSegment::find($id);
        $segment->delete();
        $requestObj->status = 'success';
        echo json_encode($requestObj);
    }

    public function saveSegment()
    {
        $requestObj = new \stdClass();
        if(MaskSegment::saveMaskSegment($this->request) > 0)
        {
            $requestObj->status = 'success';
            $requestObj->msg = 'Segment Saved Successfully !';
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Something Went Wrong while saving Segment';
        }
        echo json_encode($requestObj);
    }

    public function saveMaskingFormat()
    {
        $requestObj = new \stdClass();
        $mask = Masks::where("id" , request()->get("maskId"));
        if($mask->count() > 0)
        {
            $mask = $mask->first();
            $mask->masks = request()->get("format");
            $mask->save();
            $requestObj->status = 'success';
        }
        else{
            $requestObj->status = 'error';
        }
    }

    public function getAllColumns($model)
    {
        $requestObj = new \stdClass();
        $model = Modules::where("id" , $model);
            if($model->count() > 0 )
            {
                $requestObj->status = 'success';
                $model = $model->first()->module;
                $obj = new $model;
                $requestObj->data = $obj->getFillable();
            }
            else{
                    $requestObj->status = 'error';
                    $requestObj->msg = 'No Columns found';
            }
            echo json_encode($requestObj);
    }

    public function hasMapping()
    {
        $requestObj = new \stdClass();
        $model = Modules::where("id" , request()->get("module"));
        if($model->count() > 0 ) {
            $model = $model->first()->module;
            $obj = new $model;
            $data =  $obj->getFillable();
            $enter = false;
            foreach ($data as $row)
            {
                $enter = false;
                if($row == trim(request()->get("column")))
                {
                    $enter = true;
                    break;
                }
            }
            if ($enter)
            {
                $map = ModuleMaskMap::where("column" , trim(request()->get("column")));
                if($map->count() > 0)
                {
                    $requestObj->status = 'error';
                    $requestObj->msg = 'Column Already Mapped';
                }
                else{
                    $requestObj->status = 'success';
                }
            }
            else
            {
                $requestObj->status = 'error';
                $requestObj->msg = 'Invalid Column Name';
            }
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Invalid Module';
        }
        echo json_encode($requestObj);
    }

    public function saveMapping()
    {
        $requestObj = new \stdClass();
        $model = ModuleMaskMap::saveModuleMaskMap($this->request);
        if($model > 0)
        {
            $requestObj->status = 'success';
            $requestObj->msg = 'Mapping Saved Successfully !';
        }
        else{
            $requestObj->status = 'error';
            $requestObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($requestObj);
    }

    public function getMappings()
    {
            if ($this->request->has('take')) {
                $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
                $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
                $data = ModuleMaskMap::LoadData($this->filter)->where("ten_id" , '=',ten());
                echo shapeWithKendo($skip, $take, $data->count(), $data->get());
            } else {
                echo ModuleMaskMap::with("mask" , "module")->get();
            }
    }

    public function ValidMask()
    {
        $requestObj = new \stdClass();
        $fail = false;
        $mask = MaskSegment::with("segment")->where("mask_id" , request()->get("masking"))->get();
        foreach ($mask as $row)
        {
            $fail = true;
            $requestObj->status = 'error';
            $requestObj->msg = 'Masking Is not Valid !';
            if($row->segment->segment == 'Numeric')
            {
                if (preg_match('/[^#]/', $row->value)) {
                    $fail = true;
                    break;
                }
                else{
                    $fail = false;
                    break;
                }
            }
        }
        if( ! $fail)
        {
            $requestObj->status = 'success';
            $requestObj->msg = '';
        }
        echo json_encode($requestObj);
    }

    public function deleteMapping($id)
    {
        $requestObj = new \stdClass();
        $mask = ModuleMaskMap::where("id" , $id);
        if($mask->count() > 0)
        {
            $mask->first()->delete();
            $requestObj->status = 'success';
            $requestObj->msg = 'Mapping Deleted Successfully !';
        }
        else
        {
            $requestObj->status = 'error';
            $requestObj->msg = 'Unable to Delete mapping !';
        }
        echo json_encode($requestObj);
    }



}