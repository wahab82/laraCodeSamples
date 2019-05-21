<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CompanyRegistrationRelations;
use Illuminate\Database\Eloquent\Model;

class CompanyRegistration extends Model
{
    use CompanyRegistrationRelations;
    protected $table = 'companyregistration';
    protected $primaryKey = 'id';
    protected $fillable = ['taxregistration_id' , 'ten_id' , 'registration_no' , 'description' , 'created_by' , 'modified_by'];
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function saveRegistration($request){
        $obj = new $this;
        $obj->taxregistration_id = $request->get("registration");
        $obj->ten_id = $request->get("company");
        $obj->registration_no = $request->get("num");
        $obj->description = $request->get("details");
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
}
