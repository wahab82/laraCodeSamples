<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CompanyRelations;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CompanyRelations;
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $fillable = ['code','name','purpose','created_by','modified_by'];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with("createdByAuth" , "modifiedByAuth"));
    }

    public function saveCompany($request)
    {

        $obj = new $this;
        if($request->get("companyId") > 0)
        {
            $obj = $this->where("id",$request->get("companyId"))->first();
        }
        $obj->code = $request->get("name");
        $obj->name = $request->get("company");
        $obj->purpose = $request->get("purpose");
        if($request->get("companyId") == 0)
        {
            $obj->created_by = $this->userId;
        }
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function getEntities()
    {
        $data = array();
        $user = auth()->user();
        if ($user)
        {
            $entities = $this->where("id" , "!=" , $user->ten_id)->get();
            for ($i = 0 ; $i < count($entities) ; $i++)
            {
                $data[$i+1] = $entities[$i];
            }
            $data[0] = $this->where('id','=',$user->ten_id)->first();
        }
        return json_encode($data);
    }


}
