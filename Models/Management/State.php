<?php

namespace App\Models\Management;

use App\Models\Management\Relations\StateRelations;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use StateRelations;
    protected $table = 'state';
    protected $primaryKey = 'id';
    protected $fillable = ['name' ,'country_id','created_by','modified_by'];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeGetAll($query , $filter , $countryId)
    {
        return $filter->apply($query->where("country_id" , $countryId))->get();
    }

    public function saveState($request){
        $obj = new $this;
        $country = Country::where('id' , $request->get("country"));
        if($country->count() > 0)
        {
            $obj->name = $request->get("state");
            $obj->country_id = $country->first()->id;
            $obj->created_by = $this->userId;
            $obj->modified_by = $this->userId;
            $obj->save();
            return 1;
        }
        return 0;

    }
}
