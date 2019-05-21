<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 07/01/2018
 * Time: 04:46 PM
 */
namespace App\Http\Controllers\MasterPlanning\Traits;
use Facades\App\Models\MasterPlanning\COAPlanning as COA;
trait  COAPlanning
{

    public function GetCOAPlanning()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = COA::class;
            $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo COA::all();
        }
    }

    public function saveCOAPlanning()
    {
        $requestObj = new \stdClass();
        if(COA::isExists($this->request))
        {
            $requestObj->status = 'error';
            $requestObj->msg = 'Level Already Exists';
        }
        else{
            COA::savePlanning($this->request);
            $requestObj->status = 'success';
            $requestObj->msg = 'COA Plan Saved Successfully !';
        }
        echo json_encode($requestObj);
    }

    public function GetLevels()
    {
        return COA::all();
    }
}