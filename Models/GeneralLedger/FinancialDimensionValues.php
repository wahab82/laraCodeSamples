<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\FinancialDimensionValueRelations;
use Illuminate\Database\Eloquent\Model;

class FinancialDimensionValues extends Model
{
    use FinancialDimensionValueRelations;
    protected $table = 'financialdimval';
    protected $fillable = ['financialdim_id','value','description' ,'owner', 'ten_id' ,'created_at' , 'modified_by'];
    protected $primaryKey = 'id';
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function saveFDValues($request)
    {
        if(
            ($this
                ->where("value" , $request->get("value"))
                ->orWhere("description" , $request->get("value"))
                ->count()) > 0
        )
        {
            return -1;
        }
        $obj = new $this;
        $obj->financialdim_id = $request->get("financialDimensionId");
        $obj->value = $request->get("value");
        $obj->description = $request->get("description");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
}
