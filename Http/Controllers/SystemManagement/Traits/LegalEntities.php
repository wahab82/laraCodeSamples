<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 29/11/2017
 * Time: 08:26 PM
 */

namespace App\Http\Controllers\SystemManagement\Traits;

use App\Models\Management\City;
use App\Models\Management\Company;
use App\Models\Management\CompanyAddress;
use App\Models\Management\CompanyContact;
use App\Models\Management\CompanyRegistration;
use App\Models\Management\RegistrationTypes;
use App\Models\Management\State;
use \App\Models\Management\ContactType as ContactTypes;

trait LegalEntities
{

    public function getAllLegalEntities()
    {
        if ($this->request->has('take'))
        {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Company::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip , $take , $data->count() , $data->get());
        }
        else{
            echo Company::LoadData($this->filter)->get();
        }
    }

    public function saveLegalEntities()
    {
        $returnObj = new \stdClass();
        if( ( new Company())->saveCompany($this->request) > 0 )
        {
            $returnObj->responseStatus = 'success';
            $returnObj->msg = 'Company Saved Successfullly !';
        }
        else
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Wrong with Data';
        }
        echo json_encode($returnObj);
    }

    public function getLegalEntityDetails($id)
    {
        $returnObj = new \stdClass();
        if(is_numeric($id))
        {
            $company = $this->getCompany($id);
            if ($company)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->data = array(
                            "address"       => $this->getCompanyAddress($company->id),
                            "contact"       => $this->getCompanyContact($company->id),
                            "registration"  => $this->getCompanyRegistrationId($company->id),
                );
            }
            else
            {
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Invalid Data Passed';
            }
            echo json_encode($returnObj);
        }
    }

    public function saveCompanyAddress()
    {
        $returnObj = new \stdClass();
        if( $this->getCompany() && $this->getState() && $this->getCity() )
        {
            if( (new CompanyAddress())->saveCompanyAddress($this->request) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Address Saved Successfully !';
                $returnObj->data = array(
                            "address" => $this->getCompanyAddress($this->getCompany()->id)
                );
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Went Wrong !';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed !';
        }
        echo json_encode($returnObj);
    }
    public function saveCompanyContact()
    {
        $returnObj = new \stdClass();
        if($this->getCompany() && $this->getType())
        {
            if( (new CompanyContact())->saveContact($this->request) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Contact Saved Successfully !';
                $returnObj->data = array(
                    "contact" => $this->getCompanyContact($this->getCompany()->id)
                );
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Went Wrong !';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed !';
        }

        echo json_encode($returnObj);
    }
    public function saveCompanyRegistration()
    {
        $returnObj = new \stdClass();
        if($this->getCompany() && $this->getRegistration())
        {
            if( (new CompanyRegistration())->saveRegistration($this->request) > 0 )
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Registration Data Saved Successfully !';
                $returnObj->data = array(
                    "registration" => $this->getCompanyRegistrationId($this->getCompany()->id)
                );
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Something Went Wrong !';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data Passed !';
        }
        echo json_encode($returnObj);
    }
    public function getCompanyDetails($companyId)
    {
        $returnObj = new \stdClass();
        $data = $this->getCompany($companyId);
        if($data)
        {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Company Retrieved Successfully !';
                $returnObj->data = array(
                    "company" => $data
                );
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Unable To Retrieve Company';
        }
        echo json_encode($returnObj);
    }
    /* Delete Record Functions*/

    public function deleteAddress($id)
    {
        $returnObj = new \stdClass();
        if (is_numeric($id))
        {
            if (($data = (new CompanyAddress())->updateAddress($id)) > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Address Deleted !';
                $returnObj->data = array(
                    "address" => $this->getCompanyAddress($data)
                );
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Address Not Found';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data';
        }
        echo json_encode($returnObj);
    }
    public function deleteContact($id)
    {
        $returnObj = new \stdClass();
        if (is_numeric($id))
        {
            if (($data = (new CompanyContact())->updateContact($id)) > 0)
            {
                $returnObj->responseStatus = 'success';
                $returnObj->msg = 'Contact Deleted !';
                $returnObj->data = array(
                    "contact" => $this->getCompanyContact($data)
                );
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'Contact Not Found';
            }
        }
        else{
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Invalid Data';
        }
        echo json_encode($returnObj);
    }
    /* Ends Here*/

    public function getCompanyAddress($companyId)
    {
        return CompanyAddress::
                                with(["company" , "country","state","city","createdByAuth","modifiedByAuth"])
                                ->where("is_active" , 1)
                                ->where("ten_id",$companyId)
                                ->get();
    }public function getCompanyContact($companyId){
        return CompanyContact::
                                with(["company","contacttype","createdByAuth","modifiedByAuth"])
                                ->where("is_active" , 1)
                                ->where("ten_id",$companyId)
                                ->get();
    }public function getCompanyRegistrationId($companyId){
        return CompanyRegistration::
                                with(["company" , "registration" , "createdByAuth" , "modifiedByAuth"])
                                ->where("ten_id" , $companyId)
                                ->get();
    }
    public function getCompany($id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->get("company");
            var_dump($id);
            die();
        }
        $company = Company::where('id',$id);
        if($company->count() > 0)
        {
            return $company->first();
        }
        return false;
    }
    public function getType($id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->get("type");
        }
        $type = ContactTypes::where('id',$id);
        if($type->count() > 0)
        {
            return $type->first();
        }
        return false;
    }
    public function getRegistration($id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->get("registration");
        }
        $type = RegistrationTypes::where('id',$id);
        if($type->count() > 0)
        {
            return $type->first();
        }
        return false;
    }
    public function getState($id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->get("state");
        }
        $state = State::where('id',$id);
        if($state->count() > 0)
        {
            return $state->first();
        }
        return false;
    }
    public function getCity($id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->get("city");
        }
        $city = City::where('id',$id);
        if($city->count() > 0)
        {
            return $city->first();
        }
        return false;
    }


}