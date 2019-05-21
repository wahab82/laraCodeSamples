<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 15/12/2017
 * Time: 10:04 AM
 */

namespace App\Http\Controllers\CostAccounting\Traits;
use App\Models\CostAccounting\Currency as Currencies;
trait Currency
{
    public function getAllCurrencies()
    {
         if ($this->request->has('take'))
         {
             $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
             $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
             $model = Currencies::class;
             $data = $model::GetAll($this->filter);
             echo shapeWithKendo($skip , $take , $model::count() , $data->get());
         }
         else{
            echo Currencies::all();
         }
    }
    public function saveCurrency()
    {
        $returnObj = new \stdClass();
        if( (new Currencies())->saveCurrency($this->request) > 0 )
        {
            $returnObj->responseStatus = "success";
            $returnObj->msg = "Currency Saved Successfully !";
        }
        else{
            $returnObj->responseStatus = "error";
            $returnObj->msg = "Something Went Wrong !";
        }
        echo json_encode($returnObj);
    }
}