<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CompanyContactRelations;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    use CompanyContactRelations;
    protected $table = 'contact';
    protected $primaryKey = 'id';
    protected $fillable = ['description' , 'contacttype_id' , 'ten_id' , 'details' , 'is_active' ,'created_by' , 'modified_by'];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }
    public function saveContact($request)
    {
        $obj = new $this;
        $obj->description = $request->get("description");
        $obj->contacttype_id = $request->get("type");
        $obj->ten_id = $request->get("company");
        $obj->details = $request->get("details");
        $obj->is_active = 1;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
    public function updateContact($id)
    {
        $obj = $this->where("id" , $id);
        if($obj->count() > 0)
        {
            $obj = $obj->first();
            $obj->is_active = 0;
            $obj->modified_by = $this->userId;
            $obj->save();
            return $obj->ten_id;
        }
        return 0;
    }
}
