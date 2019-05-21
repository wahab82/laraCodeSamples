<?php

namespace App\Models\Tax;

use App\Models\Tax\Relations\SaleTaxAuthorityRelations;
use Illuminate\Database\Eloquent\Model;

class SaleTaxAuthority extends Model
{
    use SaleTaxAuthorityRelations;
    protected $table = 'saletaxauthority';
    protected $primaryKey = 'id';
    protected $fillable = ['authority' , 'description' , 'authority_code' , 'ten_id'];

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query);
    }

    public function saveAuthority($request)
    {
        $obj = new $this;
        $obj->authority = $request->get("authority");
        $obj->description = $request->get("description");
        $obj->authority_code = $request->get("identification");
        $obj->ten_id = ten();
        $obj->save();
        return 1;
    }

    public function exists($id)
    {
        return $this->where("id" ,$id)->first();
    }
}
