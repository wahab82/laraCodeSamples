<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CountryRelations;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use CountryRelations;
    protected $table = 'country';
    protected $primaryKey = 'id';
    private $userId;
    protected $fillable = ['code','name','phonecode','timezone_id','created_by','modified_by'];
    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeGetAll($query , $filter)
    {
        $query = $filter->apply($query)->get();
        return $query;
    }

    public function createCountry($request)
    {
        $obj = new $this;
        $timezone = Timezones::where('id',$request->get("timezone"));
        if($timezone->count() > 0)
        {
            $obj->code = $request->get("code");
            $obj->name = $request->get("country");
            $obj->phonecode = $request->get("phone");
            $obj->timezone_id = $timezone->first()->id;
            $obj->created_by = $this->userId;
            $obj->modified_by = $this->userId;
            $obj->save();
            return 1;
        }
        return 0;
    }
}
