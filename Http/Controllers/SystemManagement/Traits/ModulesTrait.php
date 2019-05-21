<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 24/11/2017
 * Time: 09:03 AM
 */
namespace App\Http\Controllers\SystemManagement\Traits;

use App\Filters\GenericFilter;
use App\Models\Management\Modules;
use Mockery\Exception;

trait ModulesTrait
{
    public function getAllModules()
    {
        if ($this->request->has('take'))
        {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Modules::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip , $take , $data->count() , $data->get());
        }
        else{
            echo Modules::LoadData($this->filter)->get();
        }
    }

    public function saveModules()
    {
        try
        {
            $returnObj = new \stdClass();
            if(((new Modules())->saveModule($this->request)) > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Module Added Successfully !';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Unable To Save Module';
            }
        }catch (Exception $exception)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Unexpected Exception Occured';
        }
            echo json_encode($returnObj);
    }
}