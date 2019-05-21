<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\FinancialDimensionRelations;
use Illuminate\Database\Eloquent\Model;

class FinancialDimension extends Model
{
    use FinancialDimensionRelations;
    protected $table = 'financialdim';
    protected $primaryKey = 'id';
    protected $fillable = ["value" , "name" , "col_name" , "ten_id" , "is_active"];
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with(["createdByAuth","modifiedByAuth"]));
    }

    public function saveDimension($request)
    {
        $obj = new $this;
        if ($request->get("financialDimension") > 0)
        {
            $obj = $this->where("id" , $request->get("financialDimension"));
            if($obj->count() > 0)
            {
                $obj = $obj->first();
            }
            else{
                $obj = new $this;
            }
        }
        else if(
            $this
                ->where("value" , $request->get("value"))
                ->orWhere("name" , $request->get("name"))
                ->orWhere("col_name" , $request->get("report"))
                ->count() > 0
        )
        {
            return -1;
        }

        $obj->value = $request->get("value");
        $obj->name = $request->get("name");
        $obj->col_name = $request->get("report");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->is_active = $request->get("status");
        if ($request->get("financialDimension") == 0) {
            $obj->created_by = $this->userId;
        }
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function MainAccount()
    {
        $obj = $this->where("name" , 'MainAccount');
        if(($obj->count() > 0))
        {
            return $obj->first()->id;
        }
        else{
            $obj = new $this;
            $obj->value = 'Main Account';
            $obj->name = 'MainAccount';
            $obj->col_name = 'MA';
            $obj->ten_id = auth()->user()->ten_id;
            $obj->is_active = 0;
            $obj->created_by = $this->userId;
            $obj->modified_by = $this->userId;
            $obj->save();
            return $obj->id;
        }
    }
}
