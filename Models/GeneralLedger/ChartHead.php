<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\ChartHeadRelations;
use Illuminate\Database\Eloquent\Model;

class ChartHead extends Model
{
    use ChartHeadRelations;
    protected $table = "charthead";
    protected $primaryKey = 'id';
    protected $fillable = ["head_code" , "description" , 'ten_id' , "created_by" , "modified_by"];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query->with(["createdByAuth" , "modifiedByAuth"]));
    }

    public function saveAccount($request)
    {
        $obj = new $this;
        $obj->head_code = $request->get("head");
        $obj->description = $request->get("description");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
}
