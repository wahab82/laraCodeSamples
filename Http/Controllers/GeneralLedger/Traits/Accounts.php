<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 14/12/2017
 * Time: 09:52 PM
 */

namespace App\Http\Controllers\GeneralLedger\Traits;

use App\Models\GeneralLedger\ChartHead;
use App\Models\GeneralLedger\Chartofaccount;
use App\Models\GeneralLedger\MainAccountCategories;
use App\Models\GeneralLedger\MainAccountType;
use App\Models\MasterPlanning\ModuleMaskMap;
use App\Models\MasterPlanning\Modules;

trait Accounts
{
    public function getAccountTypes()
    {
        echo MainAccountType::get();
    }

    public function getAccountCategories()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = MainAccountCategories::class;
            $data = $model::LoadData($this->filter)->where("ten_id" , '=',ten());
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo MainAccountCategories::all();
        }
    }

    public function saveAccountCategories()
    {
        $returnObj = new \stdClass();
        if ((new MainAccountCategories())->saveMainAccountCategory($this->request) > 0) {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Category Saved Successfully !';
        } else {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong with Data !';
        }
        echo json_encode($returnObj);
    }

    public function getMainAccounts()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = ChartHead::class;
            $data = $model::GetAll($this->filter)->where("ten_id" , '=',ten());
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo ChartHead::all();
        }
    }

    public function saveMainAccount()
    {
        $returnObj = new \stdClass();
        if ((new ChartHead())->saveAccount($this->request) > 0) {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Main Account Saved Successfully !';
        } else {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($returnObj);
    }

    public function getChartofAccounts($id)
    {
         if ($this->request->has('take'))
         {
             $take  = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip  = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = Chartofaccount::class;
             $data  = $model::GetAll($this->filter)->where("charthead_id" , $id)->where("ten_id" , '=',ten());
             echo shapeWithKendo($skip , $take , $data->count() , $data->get());
         }
         else{
            echo Chartofaccount::with(["createdByAuth" , "modifiedByAuth" , "mainaccounttype" , "mainaccountcategory"])->where("charthead_id",$id)->get();
         }
    }

    public function isMainAccount($id)
    {
        $returnObj = new \stdClass();
        if (is_numeric($id))
        {
            if (ChartHead::where('id',$id)->where("ten_id" , '=',ten())->count() > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = '';
            }
            else
            {
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Main Account Not Found';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed';
        }
        echo json_encode($returnObj);
    }

    public function saveChartofAccount()
    {
        $returnObj = new \stdClass();
        if ( (new Chartofaccount())->saveChartofAccount($this->request) > 0)
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Chart of Account Saved Successfully !';
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong In Chart of Accounts !';
        }
        echo json_encode($returnObj);
    }

    public function isUnique($id)
    {
        $returnObj = new \stdClass();
        if(is_numeric($id))
        {
            if( Chartofaccount::where("accountcode" , $id)->where("ten_id" , '=',ten())->count() > 0 )
            {
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Account Already Exists !';
            }
            else
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = '';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
        }
        echo json_encode($returnObj);
    }
    public function saveCOA()
    {
        $returnObj = new \stdClass();

        if( Chartofaccount::where("accountcode" , $this->request->get("accountnum"))->count() == 0 )
        {
            if ( ( new Chartofaccount() ) ->saveChartofAccount($this->request) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Account Saved Successfully !';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Went Wrong !';
            }
        }
        else{
            if($this->request->get("accountid") > 0)
            {
                if ( ( new Chartofaccount() ) ->saveChartofAccount($this->request) > 0 )
                {
                    $returnObj->responseStatus = 'success';
                    $returnObj->msg = 'Account Updated Successfully !';
                }
                else{
                    $returnObj->responseStatus = 'error';
                    $returnObj->msg = 'Something Went Wrong !';
                }
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Account Already Exists';
            }
        }
        echo json_encode($returnObj);
    }

    public function getCOAData($id)
    {
        $returnObj = new \stdClass();
        if(is_numeric($id))
        {
            if( ($data = (Chartofaccount::where('id' , $id)->where("ten_id" , '=',ten())))->count() > 0)
            {
                $data = $data->first();
                $returnObj->responseStatus = 'success';
                $returnObj->data = $data;
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'No Account Found !';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed !';
        }
        echo json_encode($returnObj);
    }
}