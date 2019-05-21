<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\FinancialDimensionSetDetailRelations;
use Illuminate\Database\Eloquent\Model;

class FinancialDimensionSetDetail extends Model
{
    use FinancialDimensionSetDetailRelations;
    protected $table = 'financialdimsetdtl';
    protected $primaryKey = 'id';
    protected $fillable = ['financialdimset_id' , 'financialdim_id' , 'ten_id' , 'created_by','modified_by'];
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query);
    }

    public function scopeGetData($query , $financialDimensionSetId)
    {
        return $query->with(["financialdim"])->where("ten_id" , '=',ten())->where("financialdimset_id" , $financialDimensionSetId)->get()->toArray();
    }

    public function saveDetail($setId , $dimId)
    {
        $obj = new $this;
        $obj->financialdimset_id = $setId;
        $obj->financialdim_id = $dimId;
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

}
