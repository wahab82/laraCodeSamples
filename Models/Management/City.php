<?php

namespace App\Models\Management;

use App\Models\Management\Relations\CityRelations;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use CityRelations;
    protected $table = 'city';
    protected $fillable = ['name' , 'state_id' , 'created_by' , 'modified_by'];
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query->with('state.country'));
    }

    public function scopeGetAll($query , $filter , $stateId)
    {
        return $filter->apply($query->where("state_id" , $stateId))->get();
    }

    public function saveCity($request)
    {
        $obj = new $this;
        $state = State::where('id' , $request->get("state"));
        if (!($state->count() > 0))
        {
            return 0;
        }
        $obj->name = $request->get("city");
        $obj->state_id = $request->get("state");
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }
}
