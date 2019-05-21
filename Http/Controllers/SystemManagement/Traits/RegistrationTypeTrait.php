<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 28/11/2017
 * Time: 08:49 PM
 */

namespace App\Http\Controllers\SystemManagement\Traits;

use App\Models\Management\RegistrationTypes;
use Mockery\Exception;

trait RegistrationTypeTrait
{
    public function getAllRegistrationTypes()
    {
        if ($this->request->has('take'))
        {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = RegistrationTypes::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip , $take , $data->count() , $data->get());
        }
        else{
            echo RegistrationTypes::all();
        }
    }

    public function saveRegistrationTypes()
    {
        $returnObj = new \stdClass();
        try{
            if( (new RegistrationTypes())->createRegistrationtype($this->request) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Registration Types Saved Successfully !';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Wrong with Data';
            }
            echo json_encode($returnObj);
        }catch(Exception $exception)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
            echo json_encode($returnObj);
        }
    }
    public function getRegistrationType($id)
    {
        $returnObj = new \stdClass();
        if(is_numeric($id))
        {
            $reg = RegistrationTypes::where('id',$id);
            if($reg->count() > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->data = $reg->first();
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'No Registration Type Found';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Arguments Passed';
        }
        echo json_encode($returnObj);
    }

    public function updateRegistrationType()
    {
        $returnObj = new \stdClass();
        if( (new RegistrationTypes())->editRegistrationType($this->request) > 0 )
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Registration Type Updated Successfully !';
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Wrong With Data';
        }
        echo json_encode($returnObj);
    }
}