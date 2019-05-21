<?php

namespace App\Models\GeneralLedger;

use Illuminate\Database\Eloquent\Model;

class FinancialDimensionSet extends Model
{
    protected $table = 'financialdimsets';
    protected $primaryKey = 'id';
    protected $fillable = ['name' , 'description' , 'ten_id'];

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query);
    }

    public function saveFinancialDimensionSet($request)
    {
        $obj = new $this;
        $obj->name = $request->get("name");
        $obj->description = $request->get("description");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->save();
        return 1;
    }
}
