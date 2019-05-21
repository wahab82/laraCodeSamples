<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\ChartofaccountRelations;
use App\Models\ModelScope;
use Illuminate\Database\Eloquent\Model;

class Chartofaccount extends Model
{
    use ChartofaccountRelations;
    protected $table = 'chartofaccounts';
    protected $primaryKey = 'id';
    protected $fillable = ["accountcode", "accountname" , "charthead_id" , "mainaccounttype_id" , "mainaccountcategory_id" , 'ten_id' , "default" , "level" , "created_by" , "updated_by"];
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }
    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query->with(["createdByAuth" , "modifiedByAuth" , "mainaccounttype" , "mainaccountcategory"]));
    }

    public function saveChartofAccount($request)
    {
        $obj = '';

        if ($request->get("accountid") > 0) {
            $obj = $this->where("id", $request->get("accountid"))->where("ten_id" , '=',ten())->first();
        }
        else {
            $obj = new $this;
            if ((MainAccountType::where("id", $request->get("accountType"))->count() > 0 &&
                MainAccountCategories::where("id", $request->get("accountCategory"))->count() > 0)
            )
            {
                /*
                 * Starts Here
                 * */
                   $financialdim_id = (new FinancialDimension())->MainAccount(); // Check for Main Account if Not found Create one
                /*
                 * Ends here
                 * */

                $obj->accountcode = $request->get("accountnum");
                $obj->accountname = $request->get("accountName");
                $obj->charthead_id = $request->get("charthead_id");
                $obj->financialdim_id = $financialdim_id;
                $obj->mainaccounttype_id = $request->get("accountType");
                $obj->mainaccountcategory_id = $request->get("accountCategory");
                $obj->ten_id = auth()->user()->ten_id;
                $obj->default = $request->get("default");
                $obj->created_by = $this->userId;
                $obj->updated_by = $this->userId;
                $obj->save();
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getFillable()
    {
        return $this->fillable;
    }
}
