<?php

namespace App\Models\Management;

use App\Models\Management\Relations\PaymentTermRelations;
use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    use PaymentTermRelations;
    protected $table='payterms';
    protected $primaryKey = 'id';
    protected $fillable = ['code' , 'description' , 'paymethod_id', 'month','days','ten_id' ,'created_by' , 'modified_by'];
    private $userId = '';
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }
    public function savePaymentTerm($request)
    {
        $obj = new $this;
        $obj->code = $request->get("code");
        $obj->description = $request->get("description");
        $obj->paymethod_id = $request->get("paymethod");
        $obj->month = $request->get("month");
        $obj->days = $request->get("days");
        $obj->ten_id = auth()->user()->ten_id;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function scopeLoadData($query ,$filter)
    {
        return $filter->apply($query->with(["createdByAuth","modifiedByAuth","paymentmethod"]));
    }
}
