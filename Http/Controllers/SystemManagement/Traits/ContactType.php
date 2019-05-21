<?php
namespace App\Http\Controllers\SystemManagement\Traits;
use App\Filters\GenericFilter;
use App\Models\Management\ContactType as ContactTypes;
use Mockery\Exception;

trait ContactType
{
    public function getContactTypes()
    {
        if ($this->request->has('take'))
        {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0 ;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = ContactTypes::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip , $take , $data->count() , $data->get());
        }
        else{
           echo ContactTypes::all();
        }
    }

    public function save()
    {
        echo (new ContactTypes())->generate($this->request->get("type"));
    }

    public function getContactTypeDetails($id)
    {
        if(is_numeric($id))
        {
            $contactType =  ContactTypes::where("id" , $id)->get();
            if(count($contactType) > 0)
            {
                echo $contactType->first()->type_name;
            }
        }
    }

    public function updateContactDetails()
    {
        $returnObj = new \stdClass();
        try
        {
            $contact = ContactTypes::whereId($this->request->get('id'));
            if ($contact->count() > 0)
            {
                if (((new ContactTypes())->updateType($contact->first() , $this->request->get("type"))) > 0)
                {
                    $returnObj->responseStatus = 'success';
                    $returnObj->msg = 'Contact Type Updated Successfully';
                }
                else{
                    $returnObj->responseStatus = 'error';
                    $returnObj->msg = 'Operation not Performed Successfully';
                }
            }
            else{
                $returnObj->responseStatus = 'error';
                $returnObj->msg = 'No Contact Type Found';
            }
            echo json_encode($returnObj);
        }catch (Exception $e)
        {
            $returnObj->responseStatus = 'error';
            $returnObj->msg = 'Something Went Wrong !';
            echo json_encode($returnObj);
        }
    }

}