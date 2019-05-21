<?php

namespace App\Models\GeneralLedger;

use App\Models\GeneralLedger\Relations\MainAccountCategoriesRelations;
use Illuminate\Database\Eloquent\Model;

class MainAccountCategories extends Model
{
    use MainAccountCategoriesRelations;
    protected $table = 'mainaccountcategories';
    protected $primaryKey = 'id';
    protected $fillable = ['accounttype' , 'description' , 'mainaccounttype_id' , 'ten_id' ,'created_by','modified_by'];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with(["mainaccounttype" ,"createdByAuth" , "modifiedByAuth"]));
    }

    public function saveMainAccountCategory($request)
    {
        $obj = new $this;
        $obj->accounttype = $request->get("category");
        $obj->description = $request->get("description");
        $obj->mainaccounttype_id = $request->get("accounttype");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
}
