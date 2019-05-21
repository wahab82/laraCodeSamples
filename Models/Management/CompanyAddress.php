<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CompanyAddressRelations;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use CompanyAddressRelations;
    protected $table = 'address';

    protected $primaryKey = 'id';

    private $userId;

    protected $fillable = ['country_id' , 'state_id' , 'city_id','ten_id','address','is_active','created_by','modified_by'];

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function saveCompanyAddress($request)
    {
        $obj = new $this();
        $obj->country_id = $request->get("country");
        $obj->state_id = $request->get("state");
        $obj->city_id = $request->get("city");
        $obj->ten_id = $request->get("company");
        $obj->address = $request->get("address");
        $obj->is_active = 1;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function updateAddress($id)
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
