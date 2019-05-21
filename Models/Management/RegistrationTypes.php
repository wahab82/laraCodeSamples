<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class RegistrationTypes extends Model
{
	protected $table = 'taxregistration';
	protected $primaryKey = 'id';
	protected $fillable = ['code','description','created_by','modified_by'];
    private $userId;

	public function __construct()
    {
        $this->userId = auth()->user()->id;
    }

    public function createRegistrationtype($request)
	{
		$obj = new $this;
	    $obj->code = $request->get("code");
	    $obj->description = $request->get("description");
	    $obj->created_by = $this->userId;
	    $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
	}
	public function scopeLoadData($query , $filter)
    {
        return $filter->apply($query);
    }

    public function editRegistrationType($request)
    {
        $obj = $this->where('id' , $request->get("id"));
        if($obj->count() > 0)
        {
            $obj = $obj->first();
            $obj->code = $request->get("code");
            $obj->description = $request->get("description");
            $obj->save();
            return 1;
        }
        return 0;
    }
}
