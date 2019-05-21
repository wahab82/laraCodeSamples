<?php

namespace App\Models\AccountsPayable;

use App\Models\AccountsPayable\Relations\VendorGroupRelations;
use App\Models\ModelScope;
use Illuminate\Database\Eloquent\Model;

class VendorGroup extends Model
{
    use VendorGroupRelations;
    protected $table = 'vendorgroup';
    protected $primaryKey = 'id';
    protected $fillable = ['code' , "description","payterm_id" , "ten_id", "created_by","modified_by"];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }
    public function saveVendorGroup($request)
    {
        $obj = new $this;
        $obj->code = $request->get("name");
        $obj->description = $request->get("description");
        $obj->payterm_id = $request->get("payMethod");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query->with(["createdByAuth" , "modifiedByAuth" , "payterm"]));
    }

    public function setCodeAttribute($code)
    {
        $this->attributes['code'] = strtoupper($code);
    }
    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = strtoupper($description);
    }

}
