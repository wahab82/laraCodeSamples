<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Timezones extends Model
{
    protected $table = 'timezone';
    protected $primaryKey = 'id';

    public function saveTimezone($timezone)
    {
        $obj = new $this;
        $obj->timezone_type = $timezone;
        $obj->created_by = auth()->user()->id;
        $obj->modified_by = auth()->user()->id;
        $obj->save();
    }

    public function scopeGetAll($query , $filter)
    {
        return $filter->apply($query)->get();
    }
}
