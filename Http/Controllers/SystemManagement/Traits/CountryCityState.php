<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 26/11/2017
 * Time: 09:41 AM
 */

namespace App\Http\Controllers\SystemManagement\Traits;

use App\Models\Management\City;
use App\Models\Management\Country;
use App\Models\Management\State;
use Mockery\Exception;

trait CountryCityState
{

    public function loadAllDetails()
    {
        if ($this->request->has('take'))
        {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = City::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip , $take , $data->count() , $data->get());
        }
        else{
            echo City::LoadData($this->filter);
        }
    }
    public function getAllCountries()
    {
            if ($this->request->exists("filter"))
            {
                if(array_key_exists("filters" , $this->request->get("filter")))
                {
                    return Country::GetAll($this->filter);
                }
            }
    }

    public function getCities()
    {
        if ($this->request->exists("filter") && $this->request->exists("stateId"))
        {
            if(array_key_exists("filters" , $this->request->get("filter")))
            {
                return City::GetAll($this->filter , $this->request->get("stateId"));
            }
        }
    }

    public function getAllStates()
    {
        if ($this->request->exists("filter") && $this->request->exists("countryId"))
        {
            if(array_key_exists("filters" , $this->request->get("filter")))
            {
                return State::GetAll($this->filter , $this->request->get("countryId"));
            }
        }
    }

    public function saveCountry()
    {
        $returnObj = new \stdClass();
        try
        {
            if ((new Country())->createCountry($this->request) > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Country Saved Successfully !';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Wrong with Data';
            }
            echo json_encode($returnObj);
        }catch(Exception $exception)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Unexpected Exception Occurred';
            echo json_encode($returnObj);
        }
    }

    public function saveState()
    {
        $returnObj = new \stdClass();
        try {
            if(((new State())->saveState($this->request)) > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'State Saved Successfully !';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Wrong with Data';
            }
            echo json_encode($returnObj);
        } catch (Exception $exception)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Unexpected Exception Occurred';
            echo json_encode($returnObj);
        }
    }

    public function saveCity()
    {
        $returnObj = new \stdClass();
        try
        {
            if( ((new City())->saveCity($this->request)) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'City Saved Successfully';
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Wrong with Data';
            }
            echo json_encode($returnObj);
        }catch(Exception $exception)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Wrong with Data';
            echo json_encode($returnObj);
        }
    }

}