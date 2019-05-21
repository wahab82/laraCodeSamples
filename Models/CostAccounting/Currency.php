<?php

namespace App\Models\CostAccounting;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';
    protected $primaryKey = 'id';
    protected $fillable = ["currency_code" , "name","symbol"];

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query);
    }

    public function saveCurrency($request)
    {
        $obj = new $this;
        $obj->currency_code = $request->get("code");
        $obj->name = $request->get("name");
        $obj->symbol = $request->get("symbol");
        $obj->save();
        return 1;
    }
}
