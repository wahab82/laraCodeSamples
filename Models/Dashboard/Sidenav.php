<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Sidenav extends Model
{
    protected  $table = "sidenav";
    protected $primaryKey = 'id';

    public function scopeNavs($query)
    {
        return $query->orderBy("link","asc")->get();
    }

}
