<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'paymethod';
    protected $primaryKey = 'id';
    protected $fillable = ['description','code','created_at','modified_by'];

    public function scopeGetAll($query)
    {
        return $query->get();
    }
}
