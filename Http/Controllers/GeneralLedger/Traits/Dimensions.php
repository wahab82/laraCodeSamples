<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 07/12/2017
 * Time: 11:22 AM
 */
namespace App\Http\Controllers\GeneralLedger\Traits;

use App\Models\GeneralLedger\FinancialDimension;
use App\Models\GeneralLedger\FinancialDimensionSet;
use App\Models\GeneralLedger\FinancialDimensionSetDetail;
use App\Models\GeneralLedger\FinancialDimensionValues;

trait Dimensions
{
    public function getFinancialDimensions()
    {
         if ($this->request->has('take'))
         {
             $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = FinancialDimension::class;
             $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
             echo shapeWithKendo($skip , $take , $model::count() , $data->get());
         }
         else{
            echo FinancialDimension::all();
         }
    }

    public function saveFinancialDimension()
    {
        $returnObj = new \stdClass();
        $data = (new FinancialDimension())->saveDimension($this->request);
        if( $data > 0 )
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Financial Dimension Saved Successfully !';
        }
        else if($data < 0){
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Values Already Exist !';
        }
        echo json_encode($returnObj);
    }

    public function getFinancialDimensionData($id)
    {
        $returnObj = new \stdClass();
        if(is_numeric($id))
        {
            $data = FinancialDimension::where("id" , $id)->where("ten_id" , '=',ten());
            if($data->count() > 0)
            {
                $returnObj->responseStatus =  'success';
                $returnObj->data = array(
                        "financialdimension" => $data->first()
                );
            }
            else{
                $returnObj->responseStatus =  'error';
                $returnObj->msg = 'Financial Dimension Not Found !';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed';
        }
        echo json_encode($returnObj);
    }

    public function getFinancialDimensionValues($id)
    {
        $returnObj = new \stdClass();
        if (is_numeric($id))
        {
            $returnObj->responseStatus = 'success';
            $returnObj->data = array(
                "financialdimensionvalues" => FinancialDimensionValues::with(["createdByAuth" , "modifiedByAuth"])->where("financialdim_id",$id)->where("ten_id" , '=',ten())->get()
            );
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed !';
        }
        echo json_encode($returnObj);
    }

    public function saveFinancialDimensionValues()
    {
        $returnObj = new \stdClass();
        $data = (new FinancialDimensionValues())->saveFDValues($this->request);
        if($data > 0)
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Financial Dimension Value Saved Successfully !';
            $returnObj->data = array(
                "financialdimensionvalues" => FinancialDimensionValues::with(["createdByAuth" , "modifiedByAuth"])->where("financialdim_id",$this->request->get("financialDimensionId"))->where("ten_id" , '=',ten())->get()
            );
        }
        else if($data < 0){
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Unable To Save Financial Dimension Values';
        }
        echo json_encode($returnObj);
    }

    public function saveFinancialDimensionSets()
    {
        $returnObj = new \stdClass();
        if( (new FinancialDimensionSet())->saveFinancialDimensionSet($this->request) > 0)
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Dimension Set Saved Successfully !';
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($returnObj);
    }

    public function getFinancialDimensionSets()
    {
         if ($this->request->has('take'))
         {
             $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = FinancialDimensionSet::class;
             $data = $model::GetAll($this->filter)->where("ten_id" , '=',ten());
             echo shapeWithKendo($skip , $take , $data->count() , $data->get());
         }
         else{
            echo FinancialDimensionSet::all();
         }
    }

    public function getFDSets($financialDimensionSetId)
    {
         $returnObj = new \stdClass();
         $Availabledimension = FinancialDimension::where("ten_id" , '=',ten())->get()->toArray();
         $selectedDimension = FinancialDimensionSetDetail::GetData($financialDimensionSetId);
         $Availabledimension = $this->intersectDimensions($Availabledimension , $selectedDimension);
         $returnObj->responseStatus = 'success';
         $returnObj->data = array(
             "available" => $Availabledimension,
             "selected" => $selectedDimension
         );

        echo json_encode($returnObj);
    }

    public function intersectDimensions($Availabledimension , $selectedDimension)
    {
        for ($i = 0 ; $i < count($selectedDimension) ; $i++)
        {
            if(($key = array_search($selectedDimension[$i]['financialdim'], $Availabledimension, TRUE)) !== FALSE) {
                unset($Availabledimension[$key]);
            }
        }
        return $Availabledimension;

    }

    public function sendDimension($setId , $dimId)
    {
        $returnObj = new \stdClass();
        if(is_numeric($setId) && is_numeric($dimId))
        {
            if(FinancialDimension::where("id" , $dimId)->where("ten_id" , '=',ten())->count() > 0 && FinancialDimensionSet::where("id" , $setId)->where("ten_id" , '=',ten())->count() > 0)
            {
                if( ( new FinancialDimensionSetDetail())->saveDetail($setId , $dimId) > 0)
                {
                    $Availabledimension = FinancialDimension::where("ten_id" , '=',ten())->get()->toArray();
                    $selectedDimension = FinancialDimensionSetDetail::GetData($setId);
                    $Availabledimension = $this->intersectDimensions($Availabledimension , $selectedDimension);
                    $returnObj->responseStatus = 'success';
                    $returnObj->data = array(
                        "available" => $Availabledimension,
                        "selected" => $selectedDimension
                    );
                }
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Invalid Data Send';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Send';
        }
        echo json_encode($returnObj);
    }

    public function removeDimensionDetail($id)
    {
        $returnObj = new \stdClass();
        $setId = 0;
        $obj =FinancialDimensionSetDetail::where('id' , $id);
        if ($obj->count() > 0)
        {
            $setId = $obj->first()->financialdimset_id;
            $obj->delete();
            $Availabledimension = FinancialDimension::all()->toArray();
            $selectedDimension = FinancialDimensionSetDetail::GetData($setId);
            $Availabledimension = $this->intersectDimensions($Availabledimension , $selectedDimension);
            $returnObj->responseStatus = 'success';
            $returnObj->data = array(
                "available" => $Availabledimension,
                "selected" => $selectedDimension
            );
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }


        echo json_encode($returnObj);
    }
}